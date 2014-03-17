<?php
App::uses('AppModel', 'Model');
App::uses('Shop', 'Model');
App::uses('Brand', 'Model');
App::uses('Product', 'Model');
App::uses('HttpSocket', 'Network/Http');


class FeedImport extends AppModel {

  protected $_Task = null;
  protected $_Brand = null;
  protected $_Product = null;

  private $CSVfieldSeparator = '__';


/**********************************************
 *
 * CORE FUNCTIONS
 *
 **********************************************/

  public function __construct($id = false, $table = null, $ds = null) {

    parent::__construct($id, $table, $ds);
    
    $this->_Task = new Task();
    $this->_Brand = new Brand();
    $this->_Product = new Product();
  }



/**********************************************
 *
 * PUBLIC FUNCTIONS
 *
 **********************************************/

/**
 * Delete a specific product(s) (images included)
 * If Brand ends up being empty, brand is also deleted
 * 
 * @param array $id Product ID(s) to be deleted
 * @return array
 */
  public function deleteShitty($id) {

    $brandsDeleted = array();
    $productsDeleted = array();

    foreach ($id as $productId) {
      $product = $this->_Product->find('first', array(
        'conditions' => array('Product.id' => $productId),
        'fields' => array('id', 'brand_id'),
        'contain' => array(
          'Brand',
          'Image' => array('id', 'product_id')
        ),
        'cache' => false
      ));

      if (!empty($product)) {
        $brandId = $product['Product']['brand_id'];
        $productsFromBrand = $this->_Product->find('count', array(
          'conditions' => array('Product.brand_id' => $brandId),
          'cache' => false
        ));

        # Delete brand
        if ($productsFromBrand < 2) {
          $this->addTaskDeleteS3Folder(Configure::read('Brand.Images.Amazon.bucket'), $brandId);
          $this->_Task->add(
            'brands/task_delete.json', 
            array('data' => array('brand_id' => $brandId)), 
            'DELETE'
          );

          $brandsDeleted[] = $brandId;
        }

        # Delete product
        $this->addTaskDeleteS3Folder(Configure::read('Product.Images.Amazon.bucket'), $productId);
        $this->_Task->add(
          'products/task_delete.json',
          array('data' => array('product_id' => $productId)), 
          'DELETE'
        );

        $productsDeleted[] = $productId;
      }
    }

    sort($brandsDeleted);
    sort($productsDeleted);

    return array('brandsDeleted' => array_unique($brandsDeleted), 'productsDeleted' => array_unique($productsDeleted));
  }



/**********************************************
 *
 * PROTECTED "MAIN" FUNCTIONS
 *
 **********************************************/

/**
 * Import all products from $file ($file only contains one brand)
 * 
 * @param string $file
 * @return mixed False on error, array on success
 */
  public function _importFeedWithOneBrand($file) {
    
    $start = microtime(true);
    $brandResults = array();
    $productResults = array();
    $productsDeleted = 0;
    $filePath = $this->_path . $this->folder . DS . $file;
    $updatedProductIds = array();

    if ($this->_fileExist($filePath) === false) {
      $this->_addError('File does not exist: ' . $filePath);
      return false;
    }

    $shopId = $this->getShopId($this->_feedName, $this->_countryCode, $this->_networkName, false);
    $oldProductIds = $this->getOldProductIds($shopId);
    
    // Get data from CSV
    $data = $this->_csvArrayToCakeArray($this->_csvToArray($filePath), $this->CSVfieldSeparator);
    
    if (count($data)) {
      // Create/Update brand
      $brandResults = $this->_createUpdateBrand($data[0]['Brand']['name'], $data[0]['Brand']['logo_url'], $this->_countryCode);
      $brandId = $brandResults['brandId'];

      // Create/Update prpducts
      $productResults = $this->_createUpdateProducts($data, $brandId, $shopId);

      if ($productResults === false) {
        return false;
      }
      
      // Save update products Ids.
      $updatedProductIds = $updatedProductIds + $productResults['updatedProductIds'];
    }
    
    // Remove products which don't belong the feed anymore.
    $removedProductIds = array_diff($oldProductIds, $updatedProductIds);

    if (!empty($removedProductIds)) {
      $productsDeleted = $this->removeOldProducts($removedProductIds);
    }


    $response = array(
      'shop_name'         => $this->_feedName,
      'network_name'      => $this->_networkName,
      'country_code'      => $this->_countryCode,
      'import_date'       => date('Y-m-d H:i:s'),
      'brands_added'      => $brandResults['addedBrands'],
      'brands_updated'    => $brandResults['updatedBrands'],
      'products_added'    => $productResults['addedProducts'],
      'products_updated'  => $productResults['updatedProducts'],
      'products_deleted'  => $productsDeleted,
      'elapsed_time_in_s' => microtime(true) - $start
    );

    $this->_saveImport($response);

    return $response;
  }


/**
 * Import all products from $file ($file contains many brands)
 * 
 * @param string $file
 * @return array
 */
  public function _importFeedWithManyBrands($file) {

    $start = microtime(true);
    $brandId = null;
    $totalbrandsAdded = 0;
    $totalbrandsUpdated = 0;
    $totalProductsAdded = 0;
    $totalProductsUpdated = 0;
    $productsDeleted = 0;
    $filePath = $this->_path . $this->folder . DS . $file;
    $updatedProductIds = array();
    
    if ($this->_fileExist($filePath) === false) {
      $this->_addError('File does not exist: ' . $filePath);
      return false;
    }

    $shopId = $this->getShopId($this->_feedName, $this->_countryCode, $this->_networkName, true);
    $oldProductIds = $this->getOldProductIds($shopId);

    // Get data from CSV
    $data = $this->_csvArrayToCakeArray($this->_csvToArray($filePath), $this->CSVfieldSeparator);
    $data = $this->_groupProductsByBrand($data);
    
    foreach ($data as $brandSlug => $brandProducts){
      // Create/Update brand
      if (count($brandProducts)) {
        $brandResults = $this->_createUpdateBrand($brandProducts[0]['Brand']['name'], $brandProducts[0]['Brand']['logo_url'], $this->_countryCode);
        
        // Update brand counters
        $totalbrandsAdded += $brandResults['addedBrands'];
        $totalbrandsUpdated += $brandResults['updatedBrands'];
        $brandId = $brandResults['brandId'];

        // Create/Update prpducts
        $productResults = $this->_createUpdateProducts($brandProducts, $brandId, $shopId);

        //Save update products Ids.
        $updatedProductIds = $updatedProductIds + $productResults['updatedProductIds'];
        
        // Update product counters
        $totalProductsAdded += $productResults['addedProducts'];
        $totalProductsUpdated += $productResults['updatedProducts'];
      }
    }

    // Remove products which don't belong the feed anymore.
    $removedProductIds = array_diff($oldProductIds, $updatedProductIds);

    if (!empty($removedProductIds)) {
      $productsDeleted = $this->removeOldProducts($removedProductIds);
    }


    $response = array(
      'shop_name'         => $this->_feedName,
      'network_name'      => $this->_networkName,
      'country_code'      => $this->_countryCode,
      'import_date'       => date('Y-m-d H:i:s'),
      'brands_added'      => $totalbrandsAdded,
      'brands_updated'    => $totalbrandsUpdated,
      'products_added'    => $totalProductsAdded,
      'products_updated'  => $totalProductsUpdated,
      'products_deleted'  => $productsDeleted,
      'elapsed_time_in_s' => microtime(true) - $start
    );

    $this->_saveImport($response);

    return $response;
  }



/**********************************************
 *
 * PROTECTED FUNCTIONS
 *
 **********************************************/

/**
 * Delete a specific product(s) (images included)
 * If Brand ends up being empty, brand is also deleted
 * 
 * @param array $id Product ID(s) to be deleted
 * @return array
 */
  protected function _groupProductsByBrand($products) {

    $sortedData = array();

    foreach ($products as $product) {

      if (count($product) && !empty($product['Brand']['name'])) {
        $brandSlug = $this->_createSlug($product['Brand']['name']);

        if (!array_key_exists($brandSlug, $sortedData)) {
          $sortedData[$brandSlug] = array();
        }

        $sortedData[$brandSlug][] = $product;
      }
    }

    return $sortedData;
  }


/**
 * Create/Update a brand and return its ID
 * 
 * @param string $brandName
 * @param string $brandLogoUrl
 * @param string $countryCode
 * @return array
 */
  protected function _createUpdateBrand($brandName, $brandLogoUrl, $countryCode) {

    $addedBrands = $updatedBrands = 0;
    $brand = $this->_Brand->find('first', array(
      'conditions' => array(
        'Brand.name' => $brandName,
        'Brand.country_code' => $countryCode
      ),
      'fields' => array('id'),
      'contain' => false,
      'cache' => false
    ));

    // Decide if update or create
    if (!empty($brand['Brand']['id'])) {
      $updatedBrands = 1;
      $this->_Brand->id = $brand['Brand']['id'];
    }
    else {
      $addedBrands = 1;
      $this->_Brand->create();
    }

    // Prepare data
    $data = array(
      'name' => $brandName,
      'country_code' => $countryCode
    );
	
	//If logo_url is not empty save logo_url and logo_filename
	if(!empty($brandLogoUrl)) {
		$data['logo_url'] = $brandLogoUrl;
		$data['logo_filename'] = $this->_getFileName($brandLogoUrl);
	}

    // Save brand
    $this->_Brand->save($data, array('validate' => false));

    // Upload logo
    if (!empty($data['logo_url'])) {
      $this->_uploadBrandLogo($data['logo_url'], $this->_Brand->id);
    }

    return array('brandId' => $this->_Brand->id, 'addedBrands' => $addedBrands, 'updatedBrands' => $updatedBrands);
  }


/**
 * Create/Update products
 * 
 * @param array $data
 * @param int $brandId
 * @param int $shopId
 * @return mixed False on error, array on success
 */
  protected function _createUpdateProducts($data, $brandId, $shopId) {
    
    $addedProducts = 0;
    $updatedProducts = 0;
    $products = $this->_mapProducts($data, $brandId, $shopId);
    $updatedProductIds = array();

    foreach ($products as $key => $product) {
      if (!empty($product['Image']) && count($product['Image'])) {
        $imageUrls = $this->_getImageUrls($product['Image']);
        unset($product['Image']);

        if (!empty($product['Product']['id'])) {
          $updatedProducts++;
          $this->_Product->id = $product['Product']['id'];
          $updatedProductIds[$product['Product']['id']] = $product['Product']['id'];
        }
        else {
          $addedProducts++;
          $this->_Product->create();
        }

        $this->_Product->saveAssociated($product, array('validate' => false));
        $this->_uploadProductImages($imageUrls, $this->_Product->id);
      }
      else {
        $this->_addError('Product without image at line ' . ($key + 1) . ': ' . $product['Product']['name']);

        return false;
      }
    }

    return array('addedProducts' => $addedProducts, 'updatedProducts' => $updatedProducts, 'updatedProductIds' => $updatedProductIds);
  }

  
/**
 * Add necessary fields to save product and its assoc. models
 * 
 * @param array $data
 * @param int $brandId
 * @param int $shopId
 * @return array
 */
  protected function _mapProducts($data, $brandId, $shopId) {

    foreach ($data as $key => $product) {
      # Set initial score
      $score = Configure::read('Product.Score.initialScore');
      $specialScores = Configure::read('Product.Score.' . $data[$key]['Product']['country_code'] . '.byCategory');

      if (!empty($specialScores[$data[$key]['Product']['category_id']])) {
        $score = $specialScores[$data[$key]['Product']['category_id']];
      }

      # Find product ID
      $productId = $this->_getProductId($product['Product']['feed_sku'], $brandId, $shopId);

      if ($productId) {
        $this->_Product->id = $productId;

        $score = $this->_Product->field('score');   # Keep current score on update
        $data[$key]['Product']['id'] = $productId;
      }

      # Merge problematic fields due stata string length limitation
      $data[$key]['Product']['url'] .= @$data[$key]['Product']['url_1'];
      $data[$key]['Product']['url'] .= @$data[$key]['Product']['url_2'];

      $data[$key]['Product']['description'] .= @$data[$key]['Product']['description_1'];
      $data[$key]['Product']['description'] .= @$data[$key]['Product']['description_2'];
      $data[$key]['Product']['description'] .= @$data[$key]['Product']['description_3'];
      $data[$key]['Product']['description'] .= @$data[$key]['Product']['description_4'];
      $data[$key]['Product']['description'] .= @$data[$key]['Product']['description_5'];

      $data[$key]['Image'][0]['url'] .= @$data[$key]['Image'][0]['url_1'];
      $data[$key]['Image'][0]['url'] .= @$data[$key]['Image'][0]['url_2'];


      $data[$key]['Product']['score']         = $score;
      #$data[$key]['Product']['country_code']   = $this->_countryCode;
      $data[$key]['Product']['price_old']     = !empty($data[$key]['Product']['price_old']) ? $data[$key]['Product']['price_old'] : 0;
      $data[$key]['Product']['shipping_cost'] = !empty($data[$key]['Product']['shipping_cost']) ? $data[$key]['Product']['shipping_cost'] : 0;
      $data[$key]['Product']['status']        = 'disabled';
      $data[$key]['Product']['shop_id']       = $shopId;
      $data[$key]['Product']['brand_id']      = $brandId;
      $data[$key]['Product']['order']         = (float)mt_rand() / (float)mt_getrandmax();
      
      unset($data[$key]['Brand']);
      unset($data[$key]['FeedImport']);   // Shouldn't be necessary
    }

    return $data;
  }

  
/**
 * Find the product ID using the Product.feed_sku as unique key in combination 
 * with thw affiliate network and brand ID
 * 
 * @param string $feedSku
 * @param int $brandId
 * @param int $shopId
 * @return mixed Int on success, NULL on error
 */
  protected function _getProductId($feedSku, $brandId, $shopId) {

    $product = $this->_Product->find('first', array(
      'conditions' => array(
        'Product.shop_id'       => $shopId,
        'Product.brand_id'      => $brandId,
        'Product.feed_sku'      => $feedSku,
        'Product.country_code'  => $this->_countryCode
      ),
      'fields' => array('id'),
      'contain' => false,
      'cache' => false
    ));

    return !empty($product['Product']['id']) ? $product['Product']['id'] : null;
  }

  
/**
 * Generate an array with all the image urls
 * 
 * @param array $images
 * @return array
 */
  protected function _getImageUrls($images) {

    $data = array();

    foreach ($images as $image) {
      $data[] = $image['url'];
    }

    return $data;
  }


/**
 * Save a new feed import result
 * 
 * @param array $result
 * @return boolean
 */
  protected function _saveImport($result) {
    
    $this->create();
    
    if ($saveResult = $this->save($result)) {
      $this->_Task->add('categories/update_availability/' . $result['country_code'] . '.json');
      $this->_Task->add('categories/update_has_sale/' . $result['country_code'] . '.json');
    }

    return $saveResult;
  }


/**
 * Upload product images asynchronously
 * (Images are saved after they have been uploaded successfully)
 * 
 * @param array $images List of image url's
 * @param int $productId
 * @return void
 */
  protected function _uploadProductImages($images, $productId) {

    $data = array(
      'type'    => 'product',
      'type_id' => $productId,
      'files'   => $images,
      'options' => array('callback' => Configure::read('Site.root') . 'images/on-upload.json')
    );

    $this->uploadImages($data);
  }


/**
 * Upload brand logo asynchronously
 * 
 * @param string $imageUrl
 * @param int $brandId
 * @return void
 */
  protected function _uploadBrandLogo($imageUrl, $brandId) {

    $data = array(
      'type'    => 'brand',
      'type_id' => $brandId,
      'files'   => array($imageUrl),
      'options' => array('callback' => Configure::read('Site.root') . 'images/on-brand-upload.json')
    );

    $this->uploadImages($data);
  }


/**
 * Get file name (with extension) from URL
 * 
 * @param string $url
 * @return string
 */
  protected function _getFileName($url) {
    
    $elements = split('/', $url); 
    $filename = $elements[count($elements) - 1];

    return substr($filename, 0);
  }



/**********************************************
 *
 * PRIVATE FUNCTIONS
 *
 **********************************************/

/**
 * Delete a S3 folder asynchronously via the internal task system
 * 
 * @param string $bucket
 * @param string $folder
 * @return boolean
 */
  private function addTaskDeleteS3Folder($bucket, $folder) {

    $url = 'images/delete-s3-folder.json';
    $data = array(
      'bucket'  => $bucket,
      'folder'  => $folder
    );

    return $this->_Task->add($url, array('data' => $data));
  }


/**
 * Upload images asynchronously
 * (Images are saved after they have been uploaded successfully)
 * 
 * @param array $data
 * @return void
 */
  private function uploadImages($data) {

    $url = 'upload/images.json';
    $this->_Task->add($url, array('data' => $data));
  }


/**
 * Get all products ids for a specific shop ID
 * 
 * @param int $shopId
 * @return array
 */
  private function getOldProductIds($shopId) {
  
    return $this->_Product->find('list', array(
      'conditions' => array('Product.shop_id' => $shopId),
      'fields' => array('id'),
      'cache' => false
    ));
  }


/**
 * Delete all products that ID is in $removedProductIds
 * 
 * @param array $removedProductIds
 * @return int Amount of deleted products
 */
  private function removeOldProducts($removedProductIds) {

    $response = $this->deleteShitty($removedProductIds);

    return count($response['productsDeleted']);
  }


/**
 * Get the shop ID using current country code, feed name and network name as conditions.
 * If shop doesn't exits, create it and return its ID
 * 
 * @param string $feedName Same as shop name
 * @param string $countryCode
 * @param string $networkName
 * @param boolean $hasManyBrands
 * @return mixed False on error, integer on success
 */
  private function getShopId($feedName, $countryCode, $networkName, $hasManyBrands) {

    $Shop = new Shop();
    $shop = $Shop->find('first', array(
      'conditions' => array(
        'Shop.name' => $feedName,
        'Shop.country_code' => $countryCode,
        'Shop.network_name' => $networkName
      ),
      'fields' => array('id'),
      'contain' => false,
      'cache' => false
    ));

    if ($shop) {
      return $shop['Shop']['id'];
    }
    else {
      $Shop->create();
      $response = $Shop->save(array(
        'name' => $feedName, 
        'country_code' => $countryCode,
        'has_many_brands' => $hasManyBrands ? 1 : 0,
        'network_name' => $networkName
      ), false);

      if ($response !== false) {
        return $Shop->id;
      }
    }

    return false;
  }
}
<?php
App::uses('AppModel', 'Model');


/**
 * CustomerAddress Model
 */
class CustomerAddress extends AppModel {

	public $displayField = 'full_address';
	public $virtualFields = array(
		'full_address' => "CONCAT(
			CustomerAddress.street_1, ', ', 
			CustomerAddress.zipcode, ' ', 
			CustomerAddress.city, ', ', 
			CustomerAddress.country_code
		)"
	);

/**
 * Validation rules
 */
	public $validate = array(
		'customer_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'last_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'street_1' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'zipcode' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'city' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
		),
		'country_code' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty')
			),
			'alphaNumeric' => array(
				'rule' => array('alphaNumeric')
			),
		),
	);

/**
 * belongsTo associations
 */
	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id'
		)
	);



/**
 * Constructor
 */
	public function __construct($id = false, $table = null, $ds = null) {

    parent::__construct($id, $table, $ds);

    // Update virtual fields with current model alias
    $this->virtualFields['full_address'] = sprintf(
      "CONCAT(%s.street_1, ', ', %s.zipcode, ' ', %s.city, ', ', %s.country_code)", 
      $this->alias, $this->alias, $this->alias, $this->alias
    );
	}
}

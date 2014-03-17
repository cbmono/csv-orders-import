<?php
App::uses('AppModel', 'Model');


/**
 * Order Model
 */
class Order extends AppModel {

	public $actsAs = array('Containable');

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
		'shipment_address_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
		'invoice_address_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
		'grand_total' => array(
			'numeric' => array(
				'rule' => array('numeric')
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
		),
		'ShipmentAddress' => array(
			'className' => 'CustomerAddress',
			'foreignKey' => 'shipment_address_id'
		),
		'InvoiceAddress' => array(
			'className' => 'CustomerAddress',
			'foreignKey' => 'invoice_address_id'
		)
	);

/**
 * hasMany associations
 */
	public $hasMany = array(
		'OrderItem' => array(
			'className' => 'OrderItem',
			'foreignKey' => 'order_id',
			'dependent' => true
		)
	);


/**
 * Get the full list of order items and every relevant Order details (Product, Order, Customer, ShipmentAddress, etc.)
 *
 * @return array
 */
	public function fullList() {

		$orderItems = $this->OrderItem->find('all', array(
			'contain' => array(
				'Product', 
				'Order' => array('Customer', 'ShipmentAddress', 'InvoiceAddress'))
		));

		// Simplify (flatten) $orderItems array structure
		foreach ($orderItems as $key => $orderItem) {
			$orderItems[$key]['Customer'] = $orderItem['Order']['Customer'];
			$orderItems[$key]['ShipmentAddress'] = $orderItem['Order']['ShipmentAddress'];
			$orderItems[$key]['InvoiceAddress'] = $orderItem['Order']['InvoiceAddress'];

			unset($orderItems[$key]['Order']['Customer']);
			unset($orderItems[$key]['Order']['ShipmentAddress']);
			unset($orderItems[$key]['Order']['InvoiceAddress']);
		}

		return $orderItems;
	}
}

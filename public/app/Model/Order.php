<?php
App::uses('AppModel', 'Model');


/**
 * Order Model
 */
class Order extends AppModel {

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
}

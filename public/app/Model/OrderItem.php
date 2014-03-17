<?php
App::uses('AppModel', 'Model');


/**
 * OrderItem Model
 */
class OrderItem extends AppModel {

	public $actsAs = array('Containable');

/**
 * Validation rules
 */
	public $validate = array(
		'order_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'product_id' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
		'quantity' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
		'price_unit' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
	);

/**
 * belongsTo associations
 */
	public $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id'
		),
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id'
		)
	);
}

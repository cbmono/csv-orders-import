<?php
App::uses('AppModel', 'Model');
/**
 * Customer Model
 *
 * @property CustomerAddress $CustomerAddress
 * @property Order $Order
 */
class Customer extends AppModel {

	public $displayField = 'full_name';
	public $virtualFields = array('full_name' => "CONCAT(Customer.first_name, ' ', Customer.last_name)");


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CustomerAddress' => array(
			'className' => 'CustomerAddress',
			'foreignKey' => 'customer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'customer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}

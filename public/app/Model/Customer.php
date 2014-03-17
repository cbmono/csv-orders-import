<?php
App::uses('AppModel', 'Model');


/**
 * Customer Model
 */
class Customer extends AppModel {

	public $displayField = 'full_name';
	public $virtualFields = array(
		'full_name' => "CONCAT(
			Customer.first_name, ' ', 
			Customer.last_name
		)"
	);

/**
 * hasMany associations
 */
	public $hasMany = array(
		'CustomerAddress' => array(
			'className' => 'CustomerAddress',
			'foreignKey' => 'customer_id',
			'dependent' => true
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'customer_id',
			'dependent' => false
		)
	);
}

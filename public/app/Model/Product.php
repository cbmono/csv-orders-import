<?php
App::uses('AppModel', 'Model');


/**
 * Product Model
 */
class Product extends AppModel {

	public $displayField = 'sku';

/**
 * Validation rules
 */
	public $validate = array(
		'sku' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'price_unit' => array(
			'numeric' => array(
				'rule' => array('numeric')
			),
		),
	);
}

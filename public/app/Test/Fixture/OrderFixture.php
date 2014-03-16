<?php
/**
 * OrderFixture
 *
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'customer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'shippment_address_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'invoice_address_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'grand_total' => array('type' => 'float', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'customer_id' => array('column' => 'customer_id', 'unique' => 0),
			'shippment_address_id' => array('column' => 'shippment_address_id', 'unique' => 0),
			'invoice_address_id' => array('column' => 'invoice_address_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'customer_id' => 1,
			'shippment_address_id' => 1,
			'invoice_address_id' => 1,
			'grand_total' => 1,
			'created' => '2014-03-17 00:06:14',
			'modified' => '2014-03-17 00:06:14'
		),
	);

}

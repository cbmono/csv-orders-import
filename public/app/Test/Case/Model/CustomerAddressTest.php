<?php
App::uses('CustomerAddress', 'Model');

/**
 * CustomerAddress Test Case
 *
 */
class CustomerAddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.customer_address',
		'app.customer'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CustomerAddress = ClassRegistry::init('CustomerAddress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CustomerAddress);

		parent::tearDown();
	}

}

<?php
App::uses('AppController', 'Controller');


/**
 * Orders Controller
 */
class OrdersController extends AppController {

	public $components = array('Paginator', 'Session');


/**
 * index method
 *
 * @return void
 */
	public function index() {

		$this->Order->recursive = 0;
		$this->set('orders', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {

		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}

		$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
		$this->set('order', $this->Order->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		if ($this->request->is('post')) {
			$this->Order->create();

			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved.'));

				return $this->redirect(array('action' => 'index'));
			} 
			else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'));
			}
		}

		$customers = $this->Order->Customer->find('list');
		$shippmentAddresses = $this->Order->ShippmentAddress->find('list');
		$invoiceAddresses = $this->Order->InvoiceAddress->find('list');
		$this->set(compact('customers', 'shippmentAddresses', 'invoiceAddresses'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order'));
		}
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved.'));
		
				return $this->redirect(array('action' => 'index'));
			} 
			else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'));
			}
		} 
		else {
			$options = array('conditions' => array('Order.' . $this->Order->primaryKey => $id));
			$this->request->data = $this->Order->find('first', $options);
		}
		
		$customers = $this->Order->Customer->find('list');
		$shippmentAddresses = $this->Order->ShippmentAddress->find('list');
		$invoiceAddresses = $this->Order->InvoiceAddress->find('list');
		$this->set(compact('customers', 'shippmentAddresses', 'invoiceAddresses'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Order->id = $id;
		
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Invalid order'));
		}
		
		$this->request->onlyAllow('post', 'delete');
		
		if ($this->Order->delete()) {
			$this->Session->setFlash(__('The order has been deleted.'));
		} 
		else {
			$this->Session->setFlash(__('The order could not be deleted. Please, try again.'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
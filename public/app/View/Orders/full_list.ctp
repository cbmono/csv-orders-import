<?php #debug($orders) ?>


<div class="row full-list">
  <button type="button" class="toogle-btn btn btn-primary btn-sm" data-toggle-el="#actions-content">
    <span class="glyphicon glyphicon-chevron-left"></span> <span class="action-label">Hide</span> actions
  </button>

  <div id="actions-content" class="col-md-2 actions">
    <h3><?=__('Actions')?></h3>
    
    <ul>
      <li><?=$this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index'))?> </li>
      <li><?=$this->Html->link(__('New Order'), array('action' => 'add'))?></li>
      <li><?=$this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index'))?> </li>
      <li><?=$this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add'))?> </li>
      <li><?=$this->Html->link(__('List Customer Addresses'), array('controller' => 'customer_addresses', 'action' => 'index'))?> </li>
      <li><?=$this->Html->link(__('New Customer Address'), array('controller' => 'customer_addresses', 'action' => 'add'))?> </li>
      <li><?=$this->Html->link(__('List Order Items'), array('controller' => 'order_items', 'action' => 'index'))?> </li>
      <li><?=$this->Html->link(__('New Order Item'), array('controller' => 'order_items', 'action' => 'add'))?> </li>
    </ul>
  </div>

  <div class="col-md-10 orders">
    <h2><?=__('Orders full list')?></h2>
    <table id="orders-full-list" class="table table-condensed table-bordered">
      <thead>
        <tr>
            <th>Order ID</th>

            <th>Customer ID</th>
            <th>Customer first name</th>
            <th>Customer last name</th>
            <th>Customer email</th>
            <th>Customer phone</th>

            <th>Shipment address ID</th>
            <th>Shipment first name</th>
            <th>Shipment last name</th>
            <th>Shipment company</th>
            <th>Shipment street_1</th>
            <th>Shipment street_2</th>
            <th>Shipment zip code</th>
            <th>Shipment city</th>
            <th>Shipment state</th>
            <th>Shipment country code</th>

            <th>Invoice address ID</th>
            <th>Invoice first name</th>
            <th>Invoice last name</th>
            <th>Invoice company</th>
            <th>Invoice street_1</th>
            <th>Invoice street_2</th>
            <th>Invoice zip code</th>
            <th>Invoice city</th>
            <th>Invoice state</th>
            <th>Invoice country code</th>

            <th>Order item ID</th>
            <th>Order item product ID</th>
            <th>Order item product</th>
            <th>Order item product SKU</th>
            <th>Order item quantity</th>
            <th>Order item price per unit</th>
            
            <th>Order grand total</th>
            <th>Order created</th>
            <th>Order modified</th>
            <th class="actions"><?=__('Actions')?></th>
        </tr>
      </thead>

      <tbody>
      <?php foreach ($orders as $order): ?>
        <tr>
          <td><?=h($order['Order']['id'])?></td>

          <td>
            <?=$this->Html->link(
              $order['Customer']['id'], 
              array('controller' => 'customers', 'action' => 'view', $order['Customer']['id'])
            )?>
          </td>
          <td><?=h($order['Customer']['first_name'])?></td>
          <td><?=h($order['Customer']['last_name'])?></td>
          <td><?=h($order['Customer']['email'])?></td>
          <td><?=h($order['Customer']['phone'])?></td>

          <td>
            <?=$this->Html->link(
              $order['ShipmentAddress']['id'], 
              array('controller' => 'customer_addresses', 'action' => 'view', $order['ShipmentAddress']['id'])
            )?>
          </td>
          <td><?=h($order['ShipmentAddress']['first_name'])?></td>
          <td><?=h($order['ShipmentAddress']['last_name'])?></td>
          <td><?=h($order['ShipmentAddress']['company'])?></td>
          <td><?=h($order['ShipmentAddress']['street_1'])?></td>
          <td><?=h($order['ShipmentAddress']['street_2'])?></td>
          <td><?=h($order['ShipmentAddress']['zipcode'])?></td>
          <td><?=h($order['ShipmentAddress']['city'])?></td>
          <td><?=h($order['ShipmentAddress']['state'])?></td>
          <td><?=h($order['ShipmentAddress']['country_code'])?></td>

          <td>
            <?=$this->Html->link(
              $order['InvoiceAddress']['id'], 
              array('controller' => 'customer_addresses', 'action' => 'view', $order['InvoiceAddress']['id'])
            )?>
          </td>
          <td><?=h($order['InvoiceAddress']['first_name'])?></td>
          <td><?=h($order['InvoiceAddress']['last_name'])?></td>
          <td><?=h($order['InvoiceAddress']['company'])?></td>
          <td><?=h($order['InvoiceAddress']['street_1'])?></td>
          <td><?=h($order['InvoiceAddress']['street_2'])?></td>
          <td><?=h($order['InvoiceAddress']['zipcode'])?></td>
          <td><?=h($order['InvoiceAddress']['city'])?></td>
          <td><?=h($order['InvoiceAddress']['state'])?></td>
          <td><?=h($order['InvoiceAddress']['country_code'])?></td>

          <td><?=h($order['OrderItem']['id'])?></td>
          <td><?=h($order['Product']['id'])?></td>
          <td><?=h($order['Product']['name'])?></td>
          <td><?=h($order['Product']['sku'])?></td>
          <td><?=h($order['OrderItem']['quantity'])?></td>
          <td><?=h($order['OrderItem']['price_unit'])?></td>

          <td><?=h($order['Order']['grand_total'])?></td>
          <td><?=h($order['Order']['created'])?></td>
          <td><?=h($order['Order']['modified'])?></td>

          <td class="actions">
            <?=$this->Html->link(__('View'), array('action' => 'view', $order['Order']['id']))?>
            <?=$this->Html->link(__('Edit'), array('action' => 'edit', $order['Order']['id']))?>
            <?=$this->Form->postLink(
              __('Delete'), 
              array('action' => 'delete', $order['Order']['id']), null, __('Are you sure you want to delete # %s?', $order['Order']['id'])
            )?>
          </td>
        </tr>
      <?php endforeach?>
      </tbody>
    </table>

  </div>
</div>


<?php #debug($orders) ?>


<div class="row full-list">
  <div class="col-md-2 actions">
    <button type="button" class="btn btn-primary btn-sm">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </button>

    <div id="actions-content">
      <h3><?=__('Actions')?></h3>
      
      <ul>
        <li><?=$this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index'))?> </li>
        <li><?=$this->Html->link(__('New Order'), array('action' => 'add'))?></li>
        <li><?=$this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index'))?> </li>
        <li><?=$this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add'))?> </li>
        <li><?=$this->Html->link(__('List Customer Addresses'), array('controller' => 'customer_addresses', 'action' => 'index'))?> </li>
        <li><?=$this->Html->link(__('New Shippment Address'), array('controller' => 'customer_addresses', 'action' => 'add'))?> </li>
        <li><?=$this->Html->link(__('List Order Items'), array('controller' => 'order_items', 'action' => 'index'))?> </li>
        <li><?=$this->Html->link(__('New Order Item'), array('controller' => 'order_items', 'action' => 'add'))?> </li>
      </ul>
    </div>
  </div>

  <div class="col-md-10 orders">
    <h2><?=__('Orders full list')?></h2>
    <table class="table table-condensed table-bordered">
      <thead>
        <tr>
            <th><?=$this->Paginator->sort('id', 'Order id')?></th>

            <th><?=$this->Paginator->sort('Customer.id')?></th>
            <th><?=$this->Paginator->sort('Customer.first_name')?></th>
            <th><?=$this->Paginator->sort('Customer.last_name')?></th>
            <th><?=$this->Paginator->sort('Customer.email')?></th>
            <th><?=$this->Paginator->sort('Customer.phone')?></th>

            <th><?=$this->Paginator->sort('ShippmentAddress.id')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.first_name', 'Shipment first name')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.last_name', 'Shipment last name')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.company', 'Shipment company')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.street_1', 'Shipment street_1')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.street_2', 'Shipment street_2')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.zipcode', 'Shipment zip code')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.city', 'Shipment city')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.state', 'Shipment state')?></th>
            <th><?=$this->Paginator->sort('ShippmentAddress.country_code', 'Shipment country code')?></th>

            <th><?=$this->Paginator->sort('InvoiceAddress.id')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.first_name', 'Invoice first name')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.last_name', 'Invoice last name')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.company', 'Invoice company')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.street_1', 'Invoice street_1')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.street_2', 'Invoice street_2')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.zipcode', 'Invoice zip code')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.city', 'Invoice city')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.state', 'Invoice state')?></th>
            <th><?=$this->Paginator->sort('InvoiceAddress.country_code', 'Invoice country code')?></th>
            
            <th><?=$this->Paginator->sort('grand_total', 'Order grand total')?></th>
            <th><?=$this->Paginator->sort('created', 'Order created')?></th>
            <th><?=$this->Paginator->sort('modified', 'Order modified')?></th>
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
              $order['ShippmentAddress']['id'], 
              array('controller' => 'customer_addresses', 'action' => 'view', $order['ShippmentAddress']['id'])
            )?>
          </td>
          <td><?=h($order['ShippmentAddress']['first_name'])?></td>
          <td><?=h($order['ShippmentAddress']['last_name'])?></td>
          <td><?=h($order['ShippmentAddress']['company'])?></td>
          <td><?=h($order['ShippmentAddress']['street_1'])?></td>
          <td><?=h($order['ShippmentAddress']['street_2'])?></td>
          <td><?=h($order['ShippmentAddress']['zipcode'])?></td>
          <td><?=h($order['ShippmentAddress']['city'])?></td>
          <td><?=h($order['ShippmentAddress']['state'])?></td>
          <td><?=h($order['ShippmentAddress']['country_code'])?></td>

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

    <p>
    <?php
      echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
      ));
    ?>  
    </p>
    
    <div class="paging">
    <?php
      echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
      echo $this->Paginator->numbers(array('separator' => ''));
      echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
  </div>
</div>


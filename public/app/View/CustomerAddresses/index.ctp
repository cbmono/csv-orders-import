<div class="customerAddresses index">
	<h2><?php echo __('Customer Addresses'); ?></h2>
	<table class="table table-condensed table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('first_name'); ?></th>
			<th><?php echo $this->Paginator->sort('last_name'); ?></th>
			<th><?php echo $this->Paginator->sort('company'); ?></th>
			<th><?php echo $this->Paginator->sort('street_1'); ?></th>
			<th><?php echo $this->Paginator->sort('street_2'); ?></th>
			<th><?php echo $this->Paginator->sort('zipcode'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('country_code'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($customerAddresses as $customerAddress): ?>
	<tr>
		<td><?php echo h($customerAddress['CustomerAddress']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($customerAddress['Customer']['full_name'], array('controller' => 'customers', 'action' => 'view', $customerAddress['Customer']['id'])); ?>
		</td>
		<td><?php echo h($customerAddress['CustomerAddress']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['company']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['street_1']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['street_2']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['zipcode']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['city']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['state']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['country_code']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['created']); ?>&nbsp;</td>
		<td><?php echo h($customerAddress['CustomerAddress']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $customerAddress['CustomerAddress']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $customerAddress['CustomerAddress']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $customerAddress['CustomerAddress']['id']), null, __('Are you sure you want to delete # %s?', $customerAddress['CustomerAddress']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Customer Address'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
	</ul>
</div>

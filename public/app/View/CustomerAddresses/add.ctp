<div class="customerAddresses form">
<?php echo $this->Form->create('CustomerAddress'); ?>
	<fieldset>
		<legend><?php echo __('Add Customer Address'); ?></legend>
	<?php
		echo $this->Form->input('customer_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('company');
		echo $this->Form->input('street_1');
		echo $this->Form->input('street_2');
		echo $this->Form->input('zipcode');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('country_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Customer Addresses'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
	</ul>
</div>

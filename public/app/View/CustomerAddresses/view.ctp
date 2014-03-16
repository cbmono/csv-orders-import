<div class="customerAddresses view">
<h2><?php echo __('Customer Address'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($customerAddress['Customer']['full_name'], array('controller' => 'customers', 'action' => 'view', $customerAddress['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['company']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street 1'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['street_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street 2'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['street_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zipcode'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['zipcode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country Code'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['country_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($customerAddress['CustomerAddress']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Customer Address'), array('action' => 'edit', $customerAddress['CustomerAddress']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Customer Address'), array('action' => 'delete', $customerAddress['CustomerAddress']['id']), null, __('Are you sure you want to delete # %s?', $customerAddress['CustomerAddress']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Customer Addresses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer Address'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
	</ul>
</div>

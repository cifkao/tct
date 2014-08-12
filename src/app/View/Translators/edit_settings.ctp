<div class="translators form">
<?php echo $this->Form->create('Translator'); ?>
	<fieldset>
		<legend><?php echo __('Edit Translator'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('activated');
		echo $this->Form->input('vacation');
		echo $this->Form->input('SrcLang');
		echo $this->Form->input('TgtLang');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Translators'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Auth Tokens'), array('controller' => 'auth_tokens', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Auth Token'), array('controller' => 'auth_tokens', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Langs'), array('controller' => 'langs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lang From'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
	</ul>
</div>

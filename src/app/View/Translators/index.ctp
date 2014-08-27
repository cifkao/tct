<div class="translators index">
	<h2><?php echo __('Translators'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('activated'); ?></th>
			<th><?php echo $this->Paginator->sort('vacation'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($translators as $translator): ?>
	<tr>
		<td><?php echo h($translator['Translator']['id']); ?>&nbsp;</td>
		<td><?php echo h($translator['Translator']['email']); ?>&nbsp;</td>
		<td><?php echo h($translator['Translator']['name']); ?>&nbsp;</td>
		<td><?php echo h($translator['Translator']['description']); ?>&nbsp;</td>
		<td><?php echo h($translator['Translator']['activated']); ?>&nbsp;</td>
		<td><?php echo h($translator['Translator']['vacation']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $translator['Translator']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $translator['Translator']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $translator['Translator']['id']), array(), __('Are you sure you want to delete # %s?', $translator['Translator']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
		<li><?php echo $this->Html->link(__('New Translator'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Auth Tokens'), array('controller' => 'auth_tokens', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Auth Token'), array('controller' => 'auth_tokens', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Translations'), array('controller' => 'translations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translation'), array('controller' => 'translations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Langs'), array('controller' => 'langs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Src Lang'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
	</ul>
</div>

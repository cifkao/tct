<div class="translations index">
	<h2><?php echo __('Translations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('text'); ?></th>
			<th><?php echo $this->Paginator->sort('post_id'); ?></th>
			<th><?php echo $this->Paginator->sort('translator_id'); ?></th>
			<th><?php echo $this->Paginator->sort('lang_id'); ?></th>
			<th><?php echo $this->Paginator->sort('score'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($translations as $translation): ?>
	<tr>
		<td><?php echo h($translation['Translation']['id']); ?>&nbsp;</td>
		<td><?php echo h($translation['Translation']['text']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($translation['Post']['id'], array('controller' => 'posts', 'action' => 'view', $translation['Post']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($translation['Translator']['email'], array('controller' => 'translators', 'action' => 'view', $translation['Translator']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($translation['Lang']['name'], array('controller' => 'langs', 'action' => 'view', $translation['Lang']['id'])); ?>
		</td>
		<td><?php echo h($translation['Translation']['score']); ?>&nbsp;</td>
		<td><?php echo h($translation['Translation']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $translation['Translation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $translation['Translation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $translation['Translation']['id']), array(), __('Are you sure you want to delete # %s?', $translation['Translation']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Translation'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Translators'), array('controller' => 'translators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translator'), array('controller' => 'translators', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Langs'), array('controller' => 'langs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lang'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
	</ul>
</div>

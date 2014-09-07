<div class="twitterTranslations index">
	<h2><?php echo __('Twitter Translations'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('tweet_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($twitterTranslations as $twitterTranslation): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($twitterTranslation['Translation']['id'], array('controller' => 'translations', 'action' => 'view', $twitterTranslation['Translation']['id'])); ?>
		</td>
		<td><?php echo h($twitterTranslation['TwitterTranslation']['tweet_id']); ?>&nbsp;</td>
		<td><?php echo h($twitterTranslation['TwitterTranslation']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $twitterTranslation['TwitterTranslation']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('List Translations'), array('controller' => 'translations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translation'), array('controller' => 'translations', 'action' => 'add')); ?> </li>
	</ul>
</div>

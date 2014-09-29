<div class="manualShutter">
	<h2><?php echo h(__('Manual Shutter') . ' | ' . __('Published Translations')); ?></h2>
  <div class="actions"><?php echo $this->Html->link(__('Show Unpublished'), array('action' => 'index')); ?></div>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo h(__('Translation')); ?></th>
			<th><?php echo h(__('Lang')); ?></th>
			<th><?php echo h(__('Text')); ?></th>
			<th><?php echo h(__('Post')); ?></th>
			<th><?php echo h(__('Src Lang')); ?></th>
			<th><?php echo h(__('Original Text')); ?></th>
			<th><?php echo h(__('Created')); ?></th>
			<th><?php echo h(__('Posted')); ?></th>
			<th><?php echo h(__('Avg Score')); ?></th>
			<th><?php echo h(__('Scorings')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $tr): ?>
	<tr>
		<td><?php echo $this->Html->link($tr['Translation']['id'], array('controller' => 'translations', 'action' => 'view', $tr['Translation']['id'])); ?>&nbsp;</td>
		<td><?php echo h($tr['Translation']['Lang']['name']); ?></td>
		<td><?php echo h($tr['Translation']['text']); ?></td>
		<td><?php echo $this->Html->link($tr['Translation']['Post']['id'], array('controller' => 'posts', 'action' => 'view', $tr['Translation']['Post']['id'])); ?>&nbsp;</td>
		<td><?php echo h($tr['Translation']['Post']['Lang']['name']); ?></td>
		<td><?php echo h($tr['Translation']['Post']['text']); ?></td>
		<td><?php echo h($tr['Translation']['created']); ?></td>
		<td><?php echo h($tr['Translation']['TwitterTranslation']['created']); ?></td>
		<td><?php echo h($tr['Translation']['avg_score']); ?></td>
		<td><?php echo h($tr['Translation']['scoring_count']); ?></td>
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

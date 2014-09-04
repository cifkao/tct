<div class="manualShutter">
	<h2><?php echo __('Manual Shutter'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo h(__('Request')); ?></th>
			<th><?php echo h(__('Post')); ?></th>
			<th><?php echo h(__('Text')); ?></th>
			<th><?php echo h(__('Lang')); ?></th>
			<th><?php echo h(__('Tgt Lang')); ?></th>
			<th><?php echo h(__('Created')); ?></th>
			<th><?php echo h(__('Translations Scored')); ?></th>
			<th class="actions"><?php echo h(__('Actions')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($reqs as $req): ?>
	<tr>
		<td><?php echo h($req['TranslationRequest']['id']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($req['Post']['id'], array('controller' => 'posts', 'action' => 'view', $req['Post']['id'])); ?>&nbsp;</td>
		<td><?php echo h($req['Post']['text']); ?>&nbsp;</td>
		<td><?php echo h($req['Post']['Lang']['name']); ?>&nbsp;</td>
		<td><?php echo h($req['TgtLang']['name']); ?>&nbsp;</td>
		<td><?php echo h($req['Post']['created']); ?>&nbsp;</td>
		<td><?php echo h($req['TranslationRequest']['translations_scored']) . " / " . h($req['TranslationRequest']['translations']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $req['TranslationRequest']['id'])); ?>
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

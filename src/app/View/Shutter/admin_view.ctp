<h2><?php echo __('Candidate Selection'); ?></h2>
<div class="manualShutter">
	<dl>
		<dt><?php echo __('Request Id'); ?></dt>
		<dd>
			<?php echo $this->Html->link($req['TranslationRequest']['id'], array('controller' => 'translation_requests', 'action' => 'view', $req['TranslationRequest']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Id'); ?></dt>
		<dd>
			<?php echo $this->Html->link($req['Post']['id'], array('controller' => 'posts', 'action' => 'view', $req['Post']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($req['Post']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lang'); ?></dt>
		<dd>
			<?php echo $this->Html->link($req['Post']['Lang']['name'], array('controller' => 'langs', 'action' => 'view', $req['Post']['Lang']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($req['Post']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<h3><?php echo __('Translations'); ?></h3>
	<?php if (!empty($translations)): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Text'); ?></th>
		<th><?php echo __('Avg Score'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($translations as $translation): ?>
		<tr>
      <td>
<?php
echo $this->Html->link($translation['Translation']['id'],
  array('controller' => 'translations', 'action' => 'view', $translation['Translation']['id']));
?>
      </td>
			<td><?php echo h($translation['Translation']['text']); ?></td>
			<td><?php echo h($translation['Translation']['avg_score']); ?></td>
			<td><?php echo h($translation['Translation']['created']); ?></td>
			<td class="actions">
<?php
echo $this->Html->link(__('Edit'),
  array('controller' => 'translations', 'action' => 'edit', $translation['Translation']['id']));
echo $this->Html->link(__('Publish'), array('action' => 'publish', $translation['Translation']['id']));
?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

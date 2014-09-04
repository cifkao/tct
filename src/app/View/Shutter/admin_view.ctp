<h2><?php echo __('Candidate Selection'); ?></h2>
<div class="manualShutter">
<h3><?php echo __('Post'); ?></h3>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($req['Post']['id']); ?>
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
		<th><?php echo __('Score'); ?></th>
		<th><?php echo __('Wins'); ?></th>
		<th><?php echo __('Losses'); ?></th>
		<th><?php echo __('Bad Marks'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($translations as $translation): ?>
		<tr>
			<td><?php echo $translation['Translation']['id']; ?></td>
			<td><?php echo $translation['Translation']['text']; ?></td>
			<td><?php echo $translation['Translation']['score']; ?></td>
			<td><?php echo $translation['Translation']['wins']; ?></td>
			<td><?php echo $translation['Translation']['losses']; ?></td>
			<td><?php echo $translation['Translation']['bad_marks']; ?></td>
			<td><?php echo $translation['Translation']['created']; ?></td>
			<td class="actions">
        <?php echo $this->Html->link(__('Publish'), array('action' => 'publish', $translation['Translation']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

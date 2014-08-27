<div class="translators view">
<h2><?php echo __('Translator'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($translator['Translator']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($translator['Translator']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($translator['Translator']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($translator['Translator']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activated'); ?></dt>
		<dd>
			<?php echo h($translator['Translator']['activated']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vacation'); ?></dt>
		<dd>
			<?php echo h($translator['Translator']['vacation']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Translator'), array('action' => 'edit', $translator['Translator']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Translator'), array('action' => 'delete', $translator['Translator']['id']), array(), __('Are you sure you want to delete # %s?', $translator['Translator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Translators'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translator'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Auth Tokens'), array('controller' => 'auth_tokens', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Auth Token'), array('controller' => 'auth_tokens', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Translations'), array('controller' => 'translations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translation'), array('controller' => 'translations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Langs'), array('controller' => 'langs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Src Lang'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Auth Tokens'); ?></h3>
	<?php if (!empty($translator['AuthToken'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Hash'); ?></th>
		<th><?php echo __('Translator Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($translator['AuthToken'] as $authToken): ?>
		<tr>
			<td><?php echo $authToken['id']; ?></td>
			<td><?php echo $authToken['hash']; ?></td>
			<td><?php echo $authToken['translator_id']; ?></td>
			<td><?php echo $authToken['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'auth_tokens', 'action' => 'view', $authToken['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'auth_tokens', 'action' => 'edit', $authToken['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'auth_tokens', 'action' => 'delete', $authToken['id']), array(), __('Are you sure you want to delete # %s?', $authToken['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Auth Token'), array('controller' => 'auth_tokens', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Translations'); ?></h3>
	<?php if (!empty($translator['Translation'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Text'); ?></th>
		<th><?php echo __('Post Id'); ?></th>
		<th><?php echo __('Translator Id'); ?></th>
		<th><?php echo __('Lang Id'); ?></th>
		<th><?php echo __('Score'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($translator['Translation'] as $translation): ?>
		<tr>
			<td><?php echo $translation['id']; ?></td>
			<td><?php echo $translation['text']; ?></td>
			<td><?php echo $translation['post_id']; ?></td>
			<td><?php echo $translation['translator_id']; ?></td>
			<td><?php echo $translation['lang_id']; ?></td>
			<td><?php echo $translation['score']; ?></td>
			<td><?php echo $translation['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'translations', 'action' => 'view', $translation['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'translations', 'action' => 'edit', $translation['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'translations', 'action' => 'delete', $translation['id']), array(), __('Are you sure you want to delete # %s?', $translation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Translation'), array('controller' => 'translations', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Langs'); ?></h3>
	<?php if (!empty($translator['SrcLang'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($translator['SrcLang'] as $srcLang): ?>
		<tr>
			<td><?php echo $srcLang['id']; ?></td>
			<td><?php echo $srcLang['code']; ?></td>
			<td><?php echo $srcLang['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'langs', 'action' => 'view', $srcLang['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'langs', 'action' => 'edit', $srcLang['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'langs', 'action' => 'delete', $srcLang['id']), array(), __('Are you sure you want to delete # %s?', $srcLang['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Src Lang'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Langs'); ?></h3>
	<?php if (!empty($translator['TgtLang'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($translator['TgtLang'] as $tgtLang): ?>
		<tr>
			<td><?php echo $tgtLang['id']; ?></td>
			<td><?php echo $tgtLang['code']; ?></td>
			<td><?php echo $tgtLang['name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'langs', 'action' => 'view', $tgtLang['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'langs', 'action' => 'edit', $tgtLang['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'langs', 'action' => 'delete', $tgtLang['id']), array(), __('Are you sure you want to delete # %s?', $tgtLang['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Tgt Lang'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>

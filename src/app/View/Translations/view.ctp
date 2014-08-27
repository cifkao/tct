<div class="translations view">
<h2><?php echo __('Translation'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($translation['Translation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($translation['Translation']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post'); ?></dt>
		<dd>
			<?php echo $this->Html->link($translation['Post']['id'], array('controller' => 'posts', 'action' => 'view', $translation['Post']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Translator'); ?></dt>
		<dd>
			<?php echo $this->Html->link($translation['Translator']['email'], array('controller' => 'translators', 'action' => 'view', $translation['Translator']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lang'); ?></dt>
		<dd>
			<?php echo $this->Html->link($translation['Lang']['name'], array('controller' => 'langs', 'action' => 'view', $translation['Lang']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Score'); ?></dt>
		<dd>
			<?php echo h($translation['Translation']['score']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($translation['Translation']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Translation'), array('action' => 'edit', $translation['Translation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Translation'), array('action' => 'delete', $translation['Translation']['id']), array(), __('Are you sure you want to delete # %s?', $translation['Translation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Translations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translation'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('controller' => 'posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('controller' => 'posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Translators'), array('controller' => 'translators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translator'), array('controller' => 'translators', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Langs'), array('controller' => 'langs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lang'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
	</ul>
</div>

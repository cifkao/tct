<div class="twitterTranslations view">
<h2><?php echo __('Twitter Translation'); ?></h2>
	<dl>
		<dt><?php echo __('Translation'); ?></dt>
		<dd>
			<?php echo $this->Html->link($twitterTranslation['Translation']['id'], array('controller' => 'translations', 'action' => 'view', $twitterTranslation['Translation']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tweet Id'); ?></dt>
		<dd>
			<?php echo h($twitterTranslation['TwitterTranslation']['tweet_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($twitterTranslation['TwitterTranslation']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Twitter Translations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('List Translations'), array('controller' => 'translations', 'action' => 'index')); ?> </li>
	</ul>
</div>

<div class="posts view">
<h2><?php echo __('Post'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($post['Post']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Text'); ?></dt>
		<dd>
			<?php echo h($post['Post']['text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lang'); ?></dt>
		<dd>
			<?php echo $this->Html->link($post['Lang']['name'], array('controller' => 'langs', 'action' => 'view', $post['Lang']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($post['Post']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Post'), array('action' => 'edit', $post['Post']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Post'), array('action' => 'delete', $post['Post']['id']), array(), __('Are you sure you want to delete # %s?', $post['Post']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Posts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Post'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Langs'), array('controller' => 'langs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lang'), array('controller' => 'langs', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Translation Requests'), array('controller' => 'translation_requests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translation Request'), array('controller' => 'translation_requests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Twitter Posts'), array('controller' => 'twitter_posts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Twitter Post'), array('controller' => 'twitter_posts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Translations'), array('controller' => 'translations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Translation'), array('controller' => 'translations', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Translation Requests'); ?></h3>
	<?php if (!empty($post['TranslationRequest'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Post Id'); ?></th>
		<th><?php echo __('Tgt Lang Id'); ?></th>
		<th><?php echo __('Hash'); ?></th>
		<th><?php echo __('Done'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($post['TranslationRequest'] as $translationRequest): ?>
		<tr>
			<td><?php echo $translationRequest['id']; ?></td>
			<td><?php echo $translationRequest['post_id']; ?></td>
			<td><?php echo $translationRequest['tgt_lang_id']; ?></td>
			<td><?php echo $translationRequest['hash']; ?></td>
			<td><?php echo $translationRequest['done']; ?></td>
			<td><?php echo $translationRequest['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'translation_requests', 'action' => 'view', $translationRequest['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'translation_requests', 'action' => 'edit', $translationRequest['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'translation_requests', 'action' => 'delete', $translationRequest['id']), array(), __('Are you sure you want to delete # %s?', $translationRequest['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Translation Request'), array('controller' => 'translation_requests', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Twitter Posts'); ?></h3>
	<?php if (!empty($post['TwitterPost'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Tweet Id'); ?></th>
		<th><?php echo __('Author Id'); ?></th>
		<th><?php echo __('Author Screen Name'); ?></th>
		<th><?php echo __('Retweet Id'); ?></th>
		<th><?php echo __('My Retweet Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($post['TwitterPost'] as $twitterPost): ?>
		<tr>
			<td><?php echo $twitterPost['id']; ?></td>
			<td><?php echo $twitterPost['tweet_id']; ?></td>
			<td><?php echo $twitterPost['author_id']; ?></td>
			<td><?php echo $twitterPost['author_screen_name']; ?></td>
			<td><?php echo $twitterPost['retweet_id']; ?></td>
			<td><?php echo $twitterPost['my_retweet_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'twitter_posts', 'action' => 'view', $twitterPost['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'twitter_posts', 'action' => 'edit', $twitterPost['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'twitter_posts', 'action' => 'delete', $twitterPost['id']), array(), __('Are you sure you want to delete # %s?', $twitterPost['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Twitter Post'), array('controller' => 'twitter_posts', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Translations'); ?></h3>
	<?php if (!empty($post['Translation'])): ?>
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
	<?php foreach ($post['Translation'] as $translation): ?>
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

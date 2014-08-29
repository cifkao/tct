<?php $this->set('bodyId', 'phrases'); ?>

<div class="large-12 columns">
	<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
	<?php foreach ($posts as $post): ?>
		<li>
			<blockquote>
				<?php echo $this->Html->link( $post['Post']['text'], array('action' => 'view', $post['Post']['id'])); ?>
				
				<cite>
					<?php echo $this->Html->link( '<i class="fi-social-twitter secondary label has-tip" data-tooltip aria-haspopup="true" title="'.__('View tweet on twitter.').'"></i>' , 'https://twitter.com/'.$post['TwitterPost'][0]['author_screen_name'].'/status/'.$post['TwitterPost'][0]['tweet_id'], array('target' => '_blank', 'escape' => false)); ?>
					<a href="http://twitter.com/<?php echo h($post['TwitterPost'][0]['author_screen_name']); ?>" target="_blank" class="label"><?php echo h($post['TwitterPost'][0]['author_screen_name']); ?></a>
					<span class="secondary label"><?php echo h($post['Post']['created']); ?></span>
					<span class="label"><?php echo h($post['Lang']['name']); ?></span>
				</cite>
				<span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('In translation to'); ?>">&raquo;</span>
				<?php foreach ( $post['TranslationRequest'] as $request ): ?>
					<span class="label"><?php echo h($request['TgtLang']['name']); ?></span>
				<?php endforeach; ?>
			</blockquote>
		</li>
	<?php endforeach; ?>
	</ul>
	<div class="pagination-centered">
		<ul class="pagination">
			<?php echo $this->Paginator->prev('&laquo; ' . __('previous'), array( 'tag' => 'li', 'class' => 'arrow', 'escape' => false ), null, array( 'tag' => 'li', 'class' => 'arrow unavailable', 'escape' => false, 'disabledTag' => 'a' )); ?>
			<?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentTag' => 'a', 'ellipsis' => '<li class="unavailable"><a href="">&hellip;</a></li>')); ?>
			<?php echo $this->Paginator->next(__('next') . ' &raquo;', array( 'tag' => 'li', 'class' => 'arrow', 'escape' => false ), null, array( 'tag' => 'li', 'class' => 'arrow unavailable', 'escape' => false, 'disabledTag' => 'a' )); ?>
		</ul>
	</div>
</div>

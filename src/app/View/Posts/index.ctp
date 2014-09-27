<?php $this->set('bodyId', 'phrases'); ?>

<div class="large-12 columns">
  <div class="row">
  <div class="large-5 large-centered columns">
    <button href="#" data-dropdown="view-select" aria-controls="view-select" aria-expanded="false" class="button dropdown expand" data-options="is_hover:true"><?php echo __('Original Tweets'); ?></button>
    <ul id="view-select" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">
      <li><?php echo $this->Html->link(__('Original Tweets'),
                array('action' => 'index')); ?></li>
      <?php foreach($langs as $code => $name){ ?>
      <li><?php echo $this->Html->link(__('Tweets translated into %s', __($name)),
                array('action' => 'translated', $code)); ?></li>
      <?php } ?>
    </ul>
  </div>
  </div>

	<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
	<?php foreach ($posts as $post): ?>
		<li>
			<blockquote>
				<?php echo $this->Html->link( $post['Post']['text'], array('action' => 'view', $post['Post']['id'])); ?>
				
				<cite>
					<?php echo $this->Html->link( '<i class="fi-social-twitter secondary label has-tip" data-tooltip aria-haspopup="true" title="'.__('View tweet on twitter.').'"></i>' , 'https://twitter.com/'.$post['TwitterPost']['author_screen_name'].'/status/'.$post['TwitterPost']['tweet_id'], array('target' => '_blank', 'escape' => false)); ?>
					<?php echo $this->Html->link( '<i class="fi-pencil secondary label has-tip" data-tooltip aria-haspopup="true" title="'.__('Submit own translation.').'"></i>' , 'mailto:twittercrowdtranslation@gmail.com?Subject=Translation&body=%0D%0A%0D%0AID:'.'FILL_HASH_HERE'.'%0D%0A%0D%0A'.urlencode($post['Post']['text']), array('target' => '_blank', 'escape' => false)); ?>
					<a href="http://twitter.com/<?php echo h($post['TwitterPost']['author_screen_name']); ?>" target="_blank" class="label"><?php echo h($post['TwitterPost']['author_screen_name']); ?></a>
					<span class="secondary label"><?php echo h($post['TwitterPost']['created']); ?></span>
					<span class="label"><?php echo h($post['Lang']['name']); ?></span>
        </cite>
        <?php if( $post['TranslationRequest'] ){ ?>
          <span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('In translation into'); ?>">&raquo;</span>
          <?php foreach ( $post['TranslationRequest'] as $request ){ ?>
            <span class="label"><?php echo h($request['TgtLang']['name']); ?></span>
          <?php } ?>
        <?php } ?>
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

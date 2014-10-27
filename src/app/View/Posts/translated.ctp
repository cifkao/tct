<?php $this->set('bodyId', 'phrases'); ?>

<script>
var ajaxUrl = "<?php echo $this->Html->url(array('controller' => 'translations', 'action' => 'add.json')); ?>";
var __translationSubmissionFailed = "<?php echo __('Failed to submit translation.'); ?>";
</script>

<div class="large-12 columns">
  <div class="row">
  <div class="large-5 large-centered columns">
    <button href="#" data-dropdown="view-select" aria-controls="view-select" aria-expanded="false" class="button dropdown expand" data-options="is_hover:true"><?php echo __('Tweets translated into %s', __($tgtLang['Lang']['name'])); ?></button>
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
	<?php foreach ($posts as $post){ ?>
		<li>
			<blockquote>
				<?php echo $this->Html->link( $post['Post']['text'], array('action' => 'view', $post['Post']['id'])); ?>
				<cite>
          <?php	if(!is_null($post['TwitterPost']['id'])){ ?>
            <?php echo $this->Html->link( '<i class="fi-social-twitter secondary label has-tip" data-tooltip aria-haspopup="true" title="'.__('View tweet on twitter.').'"></i>' , 'https://twitter.com/'.$post['TwitterPost']['author_screen_name'].'/status/'.$post['TwitterPost']['tweet_id'], array('target' => '_blank', 'escape' => false)); ?>
            <a href="http://twitter.com/<?php echo h($post['TwitterPost']['author_screen_name']); ?>" target="_blank" class="label"><?php echo h($post['TwitterPost']['author_screen_name']); ?></a>
            <span class="secondary label"><?php echo h($post['TwitterPost']['created']); ?></span>
          <?php	} ?>
					<span class="label"><?php echo h($post['Lang']['name']); ?></span>
        </cite>
    
        <ul class="small-block-grid-1">
        <?php foreach ($post['Translation'] as $translation){ ?>
          <li>
            <?php 
              echo $this->element('translation', array(
                'translation' => $translation,
                'translator' => $translation['Translator']
              ));
            ?>
          </li>
        <?php } ?>
          <li class="submit-translation" data-request-id='<?php echo $post['Translation'][0]['translation_request_id']; ?>'>
            <textarea rows="1" placeholder="<?php echo __('Add your own translation into %s…', __($tgtLang['Lang']['name'])); ?>"></textarea>
            <div class="row below-textarea">
              <div class="small-9 columns"><div class="label secondary"><?php echo __('Translating as:'); ?> Anonymous</div></div>
              <div class="small-3 columns">
                <?php echo $this->Html->link(__('Submit'), '#', array( 'class' => 'button tiny expand submit-button', 'role' => 'button') ); ?>
              </div>
            </div>
            <div class="row alerts">
              <div class="small-12 columns">
                <div class="alert-box alert radius"></div>
              </div>
            </div>
          </li>
        </ul>
			</blockquote>
		</li>
	<?php } ?>
	</ul>
	<div class="pagination-centered">
		<ul class="pagination">
			<?php echo $this->Paginator->prev('&laquo; ' . __('previous'), array( 'tag' => 'li', 'class' => 'arrow', 'escape' => false ), null, array( 'tag' => 'li', 'class' => 'arrow unavailable', 'escape' => false, 'disabledTag' => 'a' )); ?>
			<?php echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentTag' => 'a', 'ellipsis' => '<li class="unavailable"><a href="">&hellip;</a></li>')); ?>
			<?php echo $this->Paginator->next(__('next') . ' &raquo;', array( 'tag' => 'li', 'class' => 'arrow', 'escape' => false ), null, array( 'tag' => 'li', 'class' => 'arrow unavailable', 'escape' => false, 'disabledTag' => 'a' )); ?>
		</ul>
	</div>
</div>

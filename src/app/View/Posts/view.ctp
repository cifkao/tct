<?php $this->set('bodyId', 'phrases'); ?>

<div class="large-12 columns">
	<blockquote>
		<?php echo h($post['Post']['text']); ?>
		
		<cite>
			<a href="http://twitter.com/<?php echo h($post['TwitterPost']['author_screen_name']); ?>" target="_blank" class="label"><?php echo h($post['TwitterPost']['author_screen_name']); ?></a>
			<span class="secondary label"><?php echo h($post['TwitterPost']['created']); ?></span>
			<span class="label"><?php echo h($post['Lang']['name']); ?></span>
		</cite>
		<span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('In translation into'); ?>">&raquo;</span>
			<?php $requestLang = array(); ?>
			<?php foreach ( $post['TranslationRequest'] as $request ): 
				if ( !in_array( $request['TgtLang']['id'], $requestLang ) ):?>
					<span class="label"><?php echo h($request['TgtLang']['name']); ?></span>
				<?php array_push( $requestLang, $request['TgtLang']['id'] ); endif;
			endforeach; ?>
	</blockquote>
</div>
<div class="large-12 columns">	
	<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
	<?php foreach ( $post['Translation'] as $translation ): ?>
		<li>
      <?php 
        echo $this->element('translation', array(
          'translation' => $translation,
          'translator' => $translation['Translator'],
          'lang' => $translation['Lang']
        ));
      ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>

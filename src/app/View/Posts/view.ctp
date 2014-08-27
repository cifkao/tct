<?php $this->set('bodyId', 'phrases'); ?>

<div class="large-12 columns">
	<blockquote>
		<?php echo $this->Html->link( $post['Post']['text'], array('action' => 'view', $post['Post']['id'])); ?>
		
		<cite>
			<a href="#" class="label"><?php echo h($post['TwitterPost'][0]['author_screen_name']); ?></a>
			<span class="secondary label"><?php echo h($post['Post']['created']); ?></span>
			<span class="label"><?php echo h($post['Lang']['name']); ?></span>
		</cite>
		<span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('In translation to'); ?>">&raquo;</span>
			<?php $requestLang = array(); ?>
			<?php foreach ( $post['TranslationRequest'] as $request ): 
				if ( !in_array( $request['TgtLang']['id'], $requestLang ) ):?>
					<span class="label"><?php echo h($request['TgtLang']['name']); ?></span>
				<?php array_push( $requestLang, $request['TgtLang']['id'] ); endif;
			endforeach; ?>
	</blockquote>
	
	<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
	<?php foreach ( $post['Translation'] as $translation ): ?>
		<li>
			<blockquote>
				<?php echo $translation["text"]; ?>
				
				<cite>
					<?php echo $this->Html->link( h($translation['Translator']['name']), array('controller' => 'Translators', 'action' => 'view', $translation['Translator']['id']), array( 'class' => 'label' )); ?>
					<span class="secondary label"><?php echo h($translation['created']); ?></span>
					<span class="label"><?php echo h($translation['Lang']['name']); ?></span>
				</cite>
			</blockquote>
			<?php $score = ($translation['score']-1400)/(1500-1400)*100; ?>
			<?php if ( $score < 85 ): ?>
				<div class="progress round">
					<span class="meter" style="width: <?php echo $score; ?>%"></span>
				</div>
			<?php elseif ( $score < 100 ): ?>
				<div class="progress alert round">
					<span class="meter" style="width: <?php echo $score; ?>%"></span>
				</div>
			<?php else: ?>
				<div class="progress success round">
					<span class="meter" style="width: 100%"></span>
				</div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>

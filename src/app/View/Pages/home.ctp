<div class="large-12 columns">
	<p class="text-center"><?php echo __('Twitter Crowd Translation (tct) is an infrastructure for fast translation of twitter content with the help of you, members of these communities.'); ?></p>
	
	<p class="text-center panel"><?php echo __('Already %d translators provided %d translations to %d tweets in out database.', $countTranslator, $countTranslation, $countPost ); ?></p>
	
	<?php echo $this->Html->link( '<strong>' . __('Register as translator') . '</strong>', array( 'controller' => 'translators', 'action' => 'register' ), array( 'class' => 'button expand', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
</div>

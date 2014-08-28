<?php $this->set('bodyId', 'score'); ?>

<div class="large-12 columns">
<?php
if(isset($data) && $data){
?>
	<div class="row">
		<div class="large-1 columns text-center">
			<span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('Please chose better translation.'); ?>" ><i class="fi-info"></i></span>
		</div>
		<div class="large-11 columns">
			<blockquote>
				<?php echo $this->Html->para(null, $data['Post']['text']); ?>
			</blockquote>
		</div>
		
		<div class="large-6 columns">
			<?php echo $this->Html->link( $data['TranslationA']['text'], array('action' => 'score', $hash, 'b'), array( 'class' => 'button' ) ); ?>
		</div>
		<div class="large-6 columns">
			<?php echo $this->Html->link( $data['TranslationB']['text'], array('action' => 'score', $hash, 'b'), array( 'class' => 'button' ) ); ?>
		</div>
	</div>
<?php
}else{
	echo $this->Html->para(null, __('No translations to score'));
}
?>
</div>

<div class="large-12 columns">
	<div class="row">
		<div class="large-6 columns large-offset-3">
			
			<h2><?php echo __('Register as translator'); ?> <i class="fi-info has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('We only require your email for registration, you will receive message with further instructions.'); ?>"></i></h2>

			<?php echo $this->Form->create('Translator'); ?>
			
			<div class="row collapse">
				<div class="small-10 columns">
					<?php echo $this->Form->input('email', array('placeholder' => 'Email', 'div' => false, 'label' => array('class' => 'hide'))); ?>
				</div>
				<div class="small-2 columns">
					<?php echo $this->Form->end(array('label' => __('Register'), 'div' => false, 'class' => 'button postfix')); ?>
				</div>
			</div>

		</div>
	</div>
</div>

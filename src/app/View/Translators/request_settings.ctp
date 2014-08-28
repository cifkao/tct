<div class="large-12 columns">
	<div class="row">
		<div class="large-6 columns large-offset-3">
			<h2><?php echo __('Edit settings'); ?> <i class="fi-info has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('You will receive email with further instructions.'); ?>"></i></h2>

			<?php echo $this->Form->create('Translator', array('action' => 'request_settings')); ?>
			
			<div class="row collapse">
				<div class="small-10 columns">
					<?php echo $this->Form->input('email', array('placeholder' => 'Email', 'div' => false, 'label' => array('class' => 'hide'))); ?>
				</div>
				<div class="small-2 columns">
					<?php echo $this->Form->end(array('label' => __('Submit'), 'div' => false, 'class' => 'button postfix')); ?>
				</div>
			</div>

		</div>
	</div>
</div>

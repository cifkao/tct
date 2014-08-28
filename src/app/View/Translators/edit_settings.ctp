<div class="large-12 columns">
<?php echo $this->Form->create('Translator'); ?>
	<a id="start-jr" name="start-jr" onclick="$(document).foundation('joyride', 'start');" class="button tiny secondary"><?php echo __('click for Joyride'); ?></a>
	<fieldset>
		<legend><?php echo __('Edit your settings as translator'); ?></legend>
		
		<?php echo $this->Form->input('id'); ?>
		
		<?php echo $this->Form->input('name'); ?>
		
		<?php echo $this->Form->input('description'); ?>
		
		<?php echo $this->Form->input('vacation'); ?>
		
		<?php echo $this->Form->submit( __('Submit'), array('div' => false, 'class' => 'button postfix')); ?>
		
		<div class="row">
			<div class="large-6 columns">
				<fieldset>
					<legend id="SrcLang"><?php echo __('Source languages'); ?></legend>
					<?php echo $this->Form->input('SrcLang', array('type' => 'select', 'multiple' => 'multiple')); ?>
<!--
					<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
					<?php foreach ( $srcLangs as $key => $lang ): ?>
						<li>
							<?php echo $this->Form->checkbox($lang, array('name' => 'data[SrcLang][SrcLang]['.$key.']')); ?>
							<?php echo $this->Form->label($lang, $lang); ?>
						</li>
					<?php endforeach; ?>
					</ul>
-->
				</fieldset>
			</div>
			<div class="large-6 columns">
				<fieldset>
					<legend id="TgtLang"><?php echo __('Target languages'); ?></legend>
					<?php echo $this->Form->input('TgtLang', array('type' => 'select', 'multiple' => 'multiple')); ?>
<!--
					<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
					<?php foreach ( $tgtLangs as $lang ): ?>
						<li>
							<?php echo $this->Form->checkbox($lang); ?>
							<?php echo $this->Form->label($lang, $lang); ?>
						</li>
					<?php endforeach; ?>
					</ul>
-->
				</fieldset>
			</div>
		</div>
	<?php echo $this->Form->end(array('label' => __('Submit'), 'div' => false, 'class' => 'button postfix')); ?>
	</fieldset>
</div>

<ol class="joyride-list" data-joyride>
	<li data-id="TranslatorName" data-text="Next" data-options="tip_location: bottom; prev_button: false; modal: false">
		<h4>Name</h4>
		<p>Give us your name, so we can better address you.</p>
	</li>
	<li data-id="TranslatorDescription" data-text="Next" data-prev-text="Prev" data-options="tip_location: bottom; modal: false">
		<h4>Description</h4>
		<p>Improve your profile with information like contacts, education or your experience.</p>
	</li>
	<li data-id="TranslatorVacation" data-button="Next" data-prev-text="Prev" data-options="tip_location:bottom; modal: false">
		<h4>Vacation</h4>
		<p>Check if you do not want to receive requests for a time.</p>
	</li>
	<li data-id="SrcLang" data-button="Next" data-prev-text="Prev" data-options="tip_location:bottom; modal: false">
		<h4>Languages you translate FROM</h4>
		<p>Select languages you are capable of translating from. (use CTRL+Click for multiple selection)</p>
	</li>
	<li data-id="TgtLang" data-button="Next" data-prev-text="Prev" data-options="tip_location:bottom; modal: false">
		<h4>Languages you translate TO</h4>
		<p>Select languages you are capable of translating to. (use CTRL+Click for multiple selection)</p>
	</li>
	<li data-button="End" data-prev-text="Prev">
		<h4>That is all</h4>
		<p>Don't forget to save your settings.</p>
	</li>
</ol>

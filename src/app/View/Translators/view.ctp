<?php $this->set('bodyId', 'translators'); ?>

<div class="large-12 columns">
	<h2><?php echo h($translator['Translator']['name']); ?></h2>
	
	<p><?php echo h($translator['Translator']['description']); ?></p>
	<div class="row">
		<div class="small-4 large-5 columns text-center">
			<span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('Languages translator translates from.'); ?>" ><i class="fi-info"></i></span>
			<?php foreach ($translator['SrcLang'] as $srcLang): ?>
				<span class="label"><?php echo $srcLang['name']; ?></span>
			<?php endforeach; ?>
		</div>
		<div class="small-4 large-2 columns text-center">
			<span class="secondary label">&raquo;</span>
		</div>
		<div class="small-4 large-5 columns text-center">
			<?php foreach ($translator['TgtLang'] as $srcLang): ?>
				<span class="label"><?php echo $srcLang['name']; ?></span>
			<?php endforeach; ?>
			<span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('Languages translator translates to.'); ?>" ><i class="fi-info"></i></span>
		</div>
	</div>
		
</div>

<?php if (!empty($translator['Translation'])): ?>
<div class="large-12 columns">
	<hr/>
	
	<h3><?php echo __('Translated by ') . h($translator['Translator']['name']); ?></h3>
	<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
	<?php foreach ($translations as $translation): ?>
    <li>
      <?php 
        echo $this->element('translation', array(
          'translation' => $translation['Translation'],
          'translator' => $translator['Translator'],
          'lang' => $translation['Lang']
        ));
      ?>
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
<?php endif; ?>

<?php $this->set('bodyId', 'score'); ?>

<div class="large-12 columns">
<?php
if(isset($data) && $data){
?>
	<div class="row">
		<div class="large-1 columns text-center">
			<span class="secondary label has-tip" data-tooltip aria-haspopup="true" title="<?php echo __('Which statement best describes your attitude towards translation?'); ?>" ><i class="fi-info"></i></span>
		</div>
		<div class="large-11 columns">
			<blockquote>
				<?php echo h($data['Post']['text']); ?>
			</blockquote>
		</div>
		
		<div class="large-12 columns">
			<div class="panel text-center">
				<?php echo h($data['Translation']['text']); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="large-8 large-centered medium-12 small-12 columns text-center">
			<ul class="button-group score">
				<li>
					<?php echo $this->Html->link('hate it', array('action' => 'score', $hash, 1/$star_max),array('escape'=>false, 'id'=>"score-star-1", 'class' => 'button show-for-medium-up')); ?>
					<?php echo $this->Html->link('<i class="fi-skull"></i>', array('action' => 'score', $hash, 1/$star_max),array('escape'=>false, 'id'=>"score-star-1", 'class' => 'button hide-for-medium-up')); ?>
				</li>
				<li>
					<?php echo $this->Html->link('dislike it', array('action' => 'score', $hash, 2/$star_max),array('escape'=>false, 'id'=>"score-star-2", 'class' => 'button show-for-medium-up')); ?>
					<?php echo $this->Html->link('<i class="fi-dislike"></i>', array('action' => 'score', $hash, 1/$star_max),array('escape'=>false, 'id'=>"score-star-2", 'class' => 'button hide-for-medium-up')); ?>
				</li>
				<li>
					<?php echo $this->Html->link("it's OK", array('action' => 'score', $hash, 3/$star_max),array('escape'=>false, 'id'=>"score-star-3", 'class' => 'button show-for-medium-up')); ?>
					<?php echo $this->Html->link('<i class="fi-puzzle"></i>', array('action' => 'score', $hash, 1/$star_max),array('escape'=>false, 'id'=>"score-star-3", 'class' => 'button hide-for-medium-up')); ?>
				</li>
				<li>
					<?php echo $this->Html->link('like it', array('action' => 'score', $hash, 4/$star_max),array('escape'=>false, 'id'=>"score-star-4", 'class' => 'button show-for-medium-up')); ?>
					<?php echo $this->Html->link('<i class="fi-like"></i>', array('action' => 'score', $hash, 1/$star_max),array('escape'=>false, 'id'=>"score-star-4", 'class' => 'button hide-for-medium-up')); ?>
				</li>
				<li>
					<?php echo $this->Html->link('love it', array('action' => 'score', $hash, 5/$star_max),array('escape'=>false, 'id'=>"score-star-5", 'class' => 'button show-for-medium-up')); ?>
					<?php echo $this->Html->link('<i class="fi-heart"></i>', array('action' => 'score', $hash, 1/$star_max),array('escape'=>false, 'id'=>"score-star-5", 'class' => 'button hide-for-medium-up')); ?>
				</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="large-2 large-centered medium-5 medium-centered small-8 small-centered columns">
			<?php echo $this->Html->link(__("Skip"), array('action' => 'skip', $hash), array('class' => 'button small expand secondary')); ?>
		</div>
	</div>
<?php
}else{
	echo $this->Html->para(null, __('No translations to score'));
}
?>
</div>

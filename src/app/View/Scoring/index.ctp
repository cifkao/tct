<script type="text/javascript">
	$("a.score-star").hover(function(){
		$(this).find("i").addClass("highlighted");
	});
</script>
<?php
	
	echo $this->Js->writeBuffer();
?>
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
		
		<div class="large-12 columns">
			<div class="panel text-center">
				<?php echo $this->Html->para(null, $data['Translation']['text']); ?>
			</div>
		</div>
	</div>
  <div class="row">
	<div class="large-12 columns">
		<div class="small-6 medium-2 columns">
			<?php echo $this->Html->link(__("Skip"), array('action' => 'skip', $hash), array('class' => 'button small expand secondary')); ?>
		</div>
		<div class="small-6 medium-2 columns right panel">
			<?php for($i=1; $i <= $star_max; $i++){
				echo $this->Html->link('<i class="fi-star score-star"></i>', array('action' => 'score', $hash, $i/$star_max),array('escape'=>false, 'id'=>"score-star-$i", 'class'=>'score-star'));
			}
			?>
			<!--
			<i class="fi-star score-star highlighted"></i>
			<i class="fi-star score-star highlighted"></i>
			<i class="fi-star score-star highlighted"></i>

			<i class="fi-star score-star"></i>
			-->
		</div>
	</div>
  </div>
<?php
}else{
	echo $this->Html->para(null, __('No translations to score'));
}
?>
</div>

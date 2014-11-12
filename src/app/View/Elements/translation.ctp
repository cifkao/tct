<?php
if(!$translator['name'] || !$translator['activated']){
  $translator['name'] = 'Anonymous';
}
?>
<blockquote>
  <?php echo h($translation["text"]); ?>

  <cite>
    <?php echo $this->Html->link($translator['name'], array('controller' => 'translators', 'action' => 'view', $translator['id']), array( 'class' => 'label' )); ?>
    <span class="secondary label"><?php echo h($translation['created']); ?></span>
    <?php if(isset($lang)){ ?>
    <span class="label"><?php echo h($lang['name']); ?></span>
    <?php } ?>
  </cite>
</blockquote>

<?php /* ?>
<?php $score = ($translation['score']-Configure::read('Scoring.default'))/(Configure::read('Scoring.accept_threshold')-Configure::read('Scoring.default'))*50+50; ?>
<?php if ( $score < 0 ): ?>
  <div class="progress secondary round">
    <span class="meter" style="width: 0%"></span>
  </div>
<?php elseif ( $score < Configure::read('Design.score_secondary') ): ?>
  <div class="progress secondary round">
    <span class="meter" style="width: <?php echo $score; ?>%"></span>
  </div>
<?php elseif ( $score < Configure::read('Design.score_alert') ): ?>
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
<?php */ ?>

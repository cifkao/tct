<?php
if(isset($data) && $data){
?>
  <h3><?php echo __('Post'); ?></h3>
  <?php echo $this->Html->para(null, $data['Post']['text']); ?>
  <h3><?php echo $this->Html->link(__('Translation A'), array('action' => 'score', $hash, 'a')); ?></h3>
  <?php echo $this->Html->para(null, $data['TranslationA']['text']); ?>
  <h3><?php echo $this->Html->link(__('Translation B'), array('action' => 'score', $hash, 'b')); ?></h3>
  <?php echo $this->Html->para(null, $data['TranslationB']['text']); ?>
<?php
}else{
  echo $this->Html->para(null, __('No translations to score'));
}

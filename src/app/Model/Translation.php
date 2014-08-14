<?php
class Translation extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array('Post', 'Translator');


  public function add($text, $postId, $translatorId, $langId){
    $this->create();
    $this->save(array(
      'text' => $text,
      'post_id' => $postId,
      'translator_id' => $translatorId,
      'lang_id' => $langId
    ));
  }
}

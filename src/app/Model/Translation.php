<?php
class Translation extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array('Post', 'Translator', 'Lang');


  public function add($text, $postId, $translatorId, $langId){
    $this->create();
    $this->save(array(
      'text' => $text,
      'post_id' => $postId,
      'translator_id' => $translatorId,
      'lang_id' => $langId
    ));
  }

  public function score($winId, $loseId){
    $wData = $this->findById($winId);
    $lData = $this->findById($loseId);

    $wScore = $wData['Translation']['score'];
    $lScore = $lData['Translation']['score'];

    // Elo rating
    $wScore += 32*(1 - 1/(1 + pow(10, ($lScore -  $wScore)/400)));
    $lScore += 32*(0 - 1/(1 + pow(10, ($wScore  - $lScore)/400)));

    $this->id = $wData['Translation']['id'];
    $this->saveField('score', $wScore);
    $this->id = $lData['Translation']['id'];
    $this->saveField('score', $lScore);
  }

}

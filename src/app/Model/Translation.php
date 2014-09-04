<?php
class Translation extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array('Post', 'Translator', 'Lang');


  public function add($text, $postId, $translatorId, $langId){
    $post = $this->Post->findById($postId);
    if(!$post) return null;

    // Reject outright garbage (too short or too long)
    $len = strlen($text);
    $postLen = strlen($post['Post']['text']);
    if($len<$postLen/3 || $len>3*($postLen+3)){
      $tr = $this->Translator->findById($translatorId);
      $this->log('Rejecting translation of Post ' . $postId . ' by ' . ($tr ? $tr['Translator']['email'] : $translatorId) . '.', 'debug');
      return null;
    }

    $this->create();
    return $this->save(array(
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
    $this->save(array(
      'score' => $wScore,
      'wins' => $wData['Translation']['wins']+1
    ));
    $this->id = $lData['Translation']['id'];
    $this->save(array(
      'score' => $lScore,
      'losses' => $lData['Translation']['losses']+1
    ));
  }

}

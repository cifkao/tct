<?php
class Translation extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array('Post', 'TranslationRequest', 'Translator', 'Lang');


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

    $this->id = $winId;
    $this->save(array(
      'score' => $wScore,
      'wins' => $wData['Translation']['wins']+1
    ));
    $this->id = $loseId;
    $this->save(array(
      'score' => $lScore,
      'losses' => $lData['Translation']['losses']+1
    ));
  }

  public function bothBad($id1, $id2){
    $data1 = $this->findById($id1);
    $data2 = $this->findById($id2);

    $wScore = Configure::read('Scoring.both_bad_winner_score');
    $score1 = $data1['Translation']['score'];
    $score2 = $data2['Translation']['score'];

    // Elo rating against a notional winner
    $score1 += 32*(0 - 1/(1 + pow(10, ($wScore  - $score1)/400)));
    $score2 += 32*(0 - 1/(1 + pow(10, ($wScore  - $score2)/400)));

    $this->id = $id1;
    $this->save(array(
      'score' => $score1,
      'bad_marks' => $data1['Translation']['bad_marks']+1
    ));
    $this->id = $id2;
    $this->save(array(
      'score' => $score2,
      'bad_marks' => $data2['Translation']['bad_marks']+1
    ));
  }

}

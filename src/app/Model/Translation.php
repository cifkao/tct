<?php
class Translation extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array('Post', 'TranslationRequest' => array('type' => 'INNER'), 'Translator', 'Lang', 'Browser');

  public $hasOne = array(
    'TwitterTranslation' => array(
      'foreignKey' => 'id'
    )
  );

  public $hasMany = array(
    'Scoring' => array(
      'conditions' => array(
        'NOT' => array('Scoring.result' => null)
      )
    )
  );


  public function add($text, $reqId, $translatorId){
    $this->TranslationRequest->contain('Post');
    $req = $this->TranslationRequest->findById($reqId);
    if(!$req || !$req['Post']) return null;

    // Reject outright garbage (too short or too long)
    $len = strlen($text);
    $postLen = strlen($req['Post']['text']);
    if($len<$postLen/3 || $len>3*($postLen+3)){
      $tr = $this->Translator->findById($translatorId);
      $this->log('Rejecting translation of Post ' . $req['Post']['id'] . ' by ' . ($tr ? $tr['Translator']['email'] : $translatorId) . '.', 'debug');
      return null;
    }

    // Check for URL at the end of the post
    if(preg_match("/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?$/", $req['Post']['text'], $postUrl)){
      preg_match_all("/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/", $text, $textUrls);
      $found = false;
      foreach($textUrls as $url){
        if($url && $url[0] == $postUrl[0]){
          $found = true; break;
        }
      }

      if(!$found){
        $text .= " " . $postUrl[0];
      }
    }
    
    $browser = $this->Browser->current();
    $browserId = $browser ? $browser['Browser']['id'] : null;

    $this->create();
    return $this->save(array(
      'text' => $text,
      'post_id' => $req['Post']['id'],
      'translator_id' => $translatorId,
      'lang_id' => $req['TranslationRequest']['tgt_lang_id'],
      'translation_request_id' => $reqId,
      'browser_id' => $browserId
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


  public function publish($id){
    $data = $this->find('first', array(
      'conditions' => array('Translation.id' => $id),
      'contain' => array('TranslationRequest')
    ));
    if(!$data || !$data['TranslationRequest'] || $data['TranslationRequest']['accepted_translation_id'] != null) return false;

    if(!$this->TwitterTranslation->post($id))
      return false;

    $this->TranslationRequest->id = $data['TranslationRequest']['id'];
    $this->TranslationRequest->saveField('accepted_translation_id', $id);

    return true;
  }

}

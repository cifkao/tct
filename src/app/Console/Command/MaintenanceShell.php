<?php
class MaintenanceShell extends AppShell {

  public $uses = array('Translation', 'TranslationRequest', 'Scoring');

  public function updateCounters(){
    // Translation.wins, Translation.losses, Translation.bad_marks
    $translations = $this->Translation->find('all');
    foreach($translations as $tr){
      $this->Translation->id = $tr['Translation']['id'];
      $wins = 0;
      $losses = 0;
      $badMarks = 0;

      $scorings = $this->Scoring->findAllByTranslationAId($tr['Translation']['id']);
      foreach($scorings as $s){
        $res = $s['Scoring']['result'];
        if($res == 'a')
          $wins++;
        else if($res == 'b')
          $losses++;
        else if($res == 'x')
          $badMarks++;
      }

      $scorings = $this->Scoring->findAllByTranslationBId($tr['Translation']['id']);
      foreach($scorings as $s){
        $res = $s['Scoring']['result'];
        if($res == 'a')
          $losses++;
        else if($res == 'b')
          $wins++;
        else if($res == 'x')
          $badMarks++;
      }

      $this->Translation->save(array(
        'wins' => $wins,
        'losses' => $losses,
        'bad_marks' => $badMarks
      ));
    }
  }

  public function updateAssociations(){
    // TranslationRequest hasMany Translation, Translation belongsTo TranslationRequest
    $translations = $this->Translation->find('all', array('fields' => array('id', 'post_id', 'lang_id')));
    foreach($translations as $tr){
      $req = $this->TranslationRequest->findByPostIdAndTgtLangId($tr['Translation']['post_id'], $tr['Translation']['lang_id']);
      if($req){
        $this->Translation->id = $tr['Translation']['id'];
        $this->Translation->saveField('translation_request_id', $req['TranslationRequest']['id']);
      }
    }
  }

}

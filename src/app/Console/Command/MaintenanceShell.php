<?php
class MaintenanceShell extends AppShell {

  public $uses = array('Translation', 'Scoring');

  public function updateCounters(){
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

}

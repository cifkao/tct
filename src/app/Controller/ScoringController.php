<?php
App::uses('AppController', 'Controller');

class ScoringController extends AppController {
  public $scaffold = 'admin';

  public $uses = array('Scoring', 'Translation', 'Post');

  const STAR_MAX = 5;

  public function score($hash, $result){
    $data = $this->Scoring->findByHash($hash);
    if($data && is_null($data['Scoring']['result'])){
      $this->Scoring->id = $data['Scoring']['id'];
      $this->Scoring->save(array('result' => $result));
      $this->log( $this->Scoring->validationErrors );
    }

    return $this->redirect(array('action' => 'index'));
  }

  public function skip($hash){
    $data = $this->Scoring->findByHash($hash);
    if($data && is_null($data['Scoring']['result'])){
      $this->Scoring->save(array(
        'id' => $data['Scoring']['id'],
        'skipped' => true
      ));
    }

    return $this->redirect(array('action' => 'index'));
  }

  public function index(){
    $data = $this->getScoringData();
    if($data){
      $scoring = $this->Scoring->add($data);
      $this->set('data', $data);
      $this->set('hash', $scoring['Scoring']['hash']);
      $this->set('star_max', self::STAR_MAX);
    }
  }

  private function getScoringData(){
    // get a translation that the current user hasn't rated yet
    $data = $this->Translation->find('first', array(
      'contain' => array('Post'),
      'order' => 'TO_SECONDS(Translation.created) - Translation.scoring_count*60*30 DESC',
      'joins' => array(
        array(
          'type' => 'LEFT',
          'table' => 'scorings',
          'alias' => 'Scoring',
          'conditions' => array(
            'Scoring.translation_id = Translation.id'
          )
        )
      ),
      'group' =>
        "Translation.id
          HAVING SUM(CASE
          WHEN
            Scoring.user_hash = '{$this->Scoring->getUserHash()}'
            AND (
              Scoring.result IS NOT NULL
              OR
              Scoring.skipped = 1
            )
          THEN 1
          ELSE 0
          END) = 0"
    ));

    return $data;
  }

}

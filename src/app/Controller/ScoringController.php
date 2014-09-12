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
      $this->Scoring->delete($data['Scoring']['id']);
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
    // find a random translation request with at least two distinct translations
    $data = $this->Translation->find('first', array(
      'fields' => array('Translation.post_id', 'Translation.lang_id', 'Translation.translation_request_id'),
      'contain' => array('TranslationRequest' => array('fields' => array('accepted_translation_id'))),
      'conditions' => array('TranslationRequest.accepted_translation_id' => null),
      'group' => 'Translation.translation_request_id HAVING COUNT(DISTINCT Translation.text)>=2',
      'order' => 'rand()*(1/(
                    TO_SECONDS(NOW())
                    -0.5*(TO_SECONDS(TranslationRequest.created)+MAX(TO_SECONDS(Translation.created)))
                  )) DESC'
    ));
    if(!$data) return null;

    // fetch the post
    $post = $this->Post->findById($data['Translation']['post_id']);

    // get one random translation
    $translation = $this->Translation->find('first', array(
      'order' => 'rand()*(1/(
                    TO_SECONDS(NOW())
                    -TO_SECONDS(Translation.created)
                  )) DESC',
      'conditions' => array(
        'Translation.translation_request_id' => $data['Translation']['translation_request_id'],
      )
    ));

    return array(
      'Post' => $post['Post'],
      'Translation' => $translation['Translation']
    );
  }

}

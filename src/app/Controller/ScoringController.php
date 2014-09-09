<?php
App::uses('AppController', 'Controller');

class ScoringController extends AppController {
  public $scaffold = 'admin';

  public $uses = array('Scoring', 'Translation', 'Post');

  const STAR_MAX = 5;

  private function check_result($result){
    return is_float($result) && $result <= 1 && $result >= 0;
  }
  public function score($hash, $result){
    $data = $this->Scoring->findByHash($hash);
    if($data && is_null($data['Scoring']['result']) && $this->check_result($result)){
      $this->Scoring->id = $data['Scoring']['id'];
      if($this->Scoring->saveField('result', $result)){
      // $data = $this->Scoring->read();

//        if($result=='a'){
//          $this->Translation->score($data['Scoring']['translation_a_id'], $data['Scoring']['translation_b_id']);
//        }else if($result=='b'){
//          $this->Translation->score($data['Scoring']['translation_b_id'], $data['Scoring']['translation_a_id']);
//        }else if($result=='x'){
//          $this->Translation->bothBad($data['Scoring']['translation_a_id'], $data['Scoring']['translation_b_id']);
//        }
      }
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
      'order' => 'rand()*1/(
                    TO_SECONDS(NOW())
                    -0.5*(TO_SECONDS(TranslationRequest.created)+MAX(TO_SECONDS(Translation.created)))
                  ) DESC'
    ));
    if(!$data) return null;

    // fetch the post
    $post = $this->Post->findById($data['Translation']['post_id']);

    // get the ids of two random translations, group by translation text
    $this->Translation->virtualFields['ids'] = 'GROUP_CONCAT(Translation.id)';
    $translationIds = array_values($this->Translation->find('list', array(
      'fields' => array('ids'),
      'order' => 'rand()',
      'conditions' => array(
        'Translation.translation_request_id' => $data['Translation']['translation_request_id']
      ),
      'group' => 'Translation.text',
      'limit' => 1
    )));

    unset($this->Translation->virtualFields['ids']);

    // from each list of ids with the same translation text, choose one randomly
    $translation = $this->Translation->find('first', array(
      'conditions' => array(
        'Translation.id' => explode(',', $translationIds[0])
      ),
      'order' => 'rand()'
    ));

    return array(
      'Post' => $post['Post'],
      'Translation' => $translation['Translation']
    );
  }

}

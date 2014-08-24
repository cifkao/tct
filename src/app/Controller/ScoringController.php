<?php
App::uses('AppController', 'Controller');

class ScoringController extends AppController {
  public $uses = array('Scoring', 'Translation', 'Post');

  public function score($hash, $result){
    $data = $this->Scoring->findByHash($hash);
    if($data && is_null($data['Scoring']['result'])){
      $this->Scoring->id = $data['Scoring']['id'];
      if(!$this->Scoring->saveField('result', $result))
        break;

      $data = $this->Scoring->read();

      if($result=='a'){
        $this->Translation->score($data['Scoring']['translation_a_id'], $data['Scoring']['translation_b_id']);
      }else{
        $this->Translation->score($data['Scoring']['translation_b_id'], $data['Scoring']['translation_a_id']);
      }
    }

    return $this->redirect(array('action' => 'index'));
  }

  public function index(){
    $data = $this->getScoringData();
    if($data){
      $scoring = $this->Scoring->add($data);
      $this->set('data', $data);
      $this->set('hash', $scoring['Scoring']['hash']);
    }
  }

  private function getScoringData(){
    // find a random post with at least two translations in the same lang
    $data = $this->Translation->find('first', array(
      'order' => 'rand()',
      'fields' => array('Translation.post_id', 'Translation.lang_id'),
      'group' => 'Translation.post_id, Translation.lang_id HAVING COUNT(*)>=2'
    ));
    if(!$data) return null;
    // get the post and two random translations
    $this->Post->contain(array('Translation' => array(
      'order' => 'rand()',
      'conditions' => array(
        'Translation.lang_id' => $data['Translation']['lang_id']
      ),
      'limit' => 2
    )));
    $data = $this->Post->findById($data['Translation']['post_id']);

    return array(
      'Post' => $data['Post'],
      'TranslationA' => $data['Translation'][0],
      'TranslationB' => $data['Translation'][1]
    );
  }

}

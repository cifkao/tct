<?php
App::uses('AppController', 'Controller');

class ScoringController extends AppController {

  public $scaffold = 'admin';

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
      }else if($result=='b'){
        $this->Translation->score($data['Scoring']['translation_b_id'], $data['Scoring']['translation_a_id']);
      }else if($result=='x'){
        $this->Translation->bothBad($data['Scoring']['translation_a_id'], $data['Scoring']['translation_b_id']);
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
    }
  }

  private function getScoringData(){
    // find a random post with at least two distinct translations in the same lang
    $data = $this->Translation->find('first', array(
      'order' => 'rand()',
      'fields' => array('Translation.post_id', 'Translation.lang_id'),
      'group' => 'Translation.post_id, Translation.lang_id HAVING COUNT(DISTINCT Translation.text)>=2'
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
        'Translation.post_id' => $data['Translation']['post_id'],
        'Translation.lang_id' => $data['Translation']['lang_id']
      ),
      'group' => 'Translation.text',
      'limit' => 2
    )));
    unset($this->Translation->virtualFields['ids']);

    // from each list of ids with the same translation text, choose one randomly
    $translationA = $this->Translation->find('first', array(
      'conditions' => array(
        'Translation.id' => explode(',', $translationIds[0])
      ),
      'order' => 'rand()'
    ));
    $translationB = $this->Translation->find('first', array(
      'conditions' => array(
        'Translation.id' => explode(',', $translationIds[1])
      ),
      'order' => 'rand()'
    ));

    return array(
      'Post' => $post['Post'],
      'TranslationA' => $translationA['Translation'],
      'TranslationB' => $translationB['Translation']
    );
  }

}

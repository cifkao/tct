<?php
App::uses('AppController', 'Controller');

class ShutterController extends AppController {

  public $uses = array('Translation', 'TranslationRequest');

  public $components = array('Paginator');

  public function admin_index() {
    // find translation requests with at least two scorings
    $this->Paginator->settings = array(
      'joins' => array(
        array(
          'table' => 'translation_requests',
          'alias' => 'TranslationRequest',
          'conditions' => array(
            'Translation.post_id = TranslationRequest.post_id',
            'Translation.lang_id = TranslationRequest.tgt_lang_id'
          )
        )
      ),
      'conditions' => array('TranslationRequest.accepted_translation_id' => null),
      'fields' => array('id', 'wins', 'losses', 'TranslationRequest.post_id', 'TranslationRequest.tgt_lang_id', 'TranslationRequest.id'),
      'group' => 'TranslationRequest.id HAVING SUM(Translation.wins + Translation.losses) >= 2*2'
    );
    $reqIds = array_map(function($value){
      return $value['TranslationRequest']['id'];
    }, $this->Paginator->paginate("Translation"));
    
    // fetch the requests
    $this->TranslationRequest->resetAssociations(); // we need to do this
    $this->TranslationRequest->recursive = 2;
    $reqs = $this->TranslationRequest->find('all',
      array(
        'contain' => array('Post' => array('Lang'), 'TgtLang'),
        'conditions' => array('TranslationRequest.id' => $reqIds),
        'order' => array('TranslationRequest.created' => 'DESC')
      )
    );
    // count scored translations
    foreach($reqs as &$req){
      $req['TranslationRequest']['translations'] = $this->Translation->find('count', array(
        'conditions' => array(
          'Translation.post_id' => $req['TranslationRequest']['post_id'],
          'Translation.lang_id' => $req['TranslationRequest']['tgt_lang_id']
        )
      ));
      $req['TranslationRequest']['translations_scored'] = $this->Translation->find('count', array(
        'conditions' => array(
          'Translation.post_id' => $req['TranslationRequest']['post_id'],
          'Translation.lang_id' => $req['TranslationRequest']['tgt_lang_id'],
          'Translation.wins + Translation.losses > 0'
        )
      ));
      $req['TranslationRequest']['best_score'] = $this->Translation->find('first', array(
        'conditions' => array(
          'Translation.post_id' => $req['TranslationRequest']['post_id'],
          'Translation.lang_id' => $req['TranslationRequest']['tgt_lang_id'],
        ),
        'order' => array('Translation.score' => 'DESC')
      ))['Translation']['score'];
    }
    $this->set('reqs', $reqs);
  }

  public function admin_view($id = null) {
    if (!$this->TranslationRequest->exists($id)) {
      throw new NotFoundException(__('Invalid request'));
    }
    $this->TranslationRequest->recursive = 2;
    $req = $this->TranslationRequest->find('first', array(
      'conditions' => array('TranslationRequest.id' => $id),
      'contain' => array('Post' => array('Lang'), 'TgtLang')
    ));
    $translations = $this->Translation->find('all', array(
      'conditions' => array(
        'Translation.post_id' => $req['Post']['id'],
        'Translation.lang_id' => $req['TgtLang']['id'],
      ),
      'order' => 'Translation.score DESC'
    ));
    $this->set('req', $req);
    $this->set('translations', $translations);
  }

  public function admin_publish($id){
    if($this->Translation->publish($id)){
      $this->Session->setFlash(__("Post published."));
    }else{
      $this->Session->setFlash(__("Failed to publish post."));
    }
    return $this->redirect(array('action' => 'admin_index'));
  }

}

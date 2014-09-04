<?php
App::uses('AppController', 'Controller');

class ShutterController extends AppController {

  public $uses = array('Translation', 'TranslationRequest');

  public $components = array('Paginator');

  public function admin_index() {
    // find translation requests with at least two scorings
    $this->Translation->recursive = 2;
    $this->Translation->bindModel(array('belongsTo' => array(
      'TranslationRequest' => array(
        'foreignKey' => false,
        'conditions' => array(
          'Translation.post_id = TranslationRequest.post_id',
          'Translation.lang_id = TranslationRequest.tgt_lang_id'
        )
      )
    )));
    $this->Paginator->settings = array(
      'contain' => array(
        'TranslationRequest' => array(
          'fields' => array('id')
        )),
      'fields' => array('id', 'wins', 'losses'),
      'group' => 'TranslationRequest.id HAVING SUM(Translation.wins + Translation.losses) >= 1'
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
;
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

}

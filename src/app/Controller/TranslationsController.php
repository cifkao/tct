<?php
App::uses('AppController', 'Controller');

class TranslationsController extends AppController {
  public $scaffold = 'admin';

  public $components = array('Paginator', 'RequestHandler');

  public $uses = array('Translation', 'Translator', 'Setting');

  public function add(){
    if($this->request->is('post') && array_key_exists('text', $this->request->data) && array_key_exists('requestId', $this->request->data)){
      $translatorId = $this->Setting->getNumber('AnonymousTranslator.id');
      if(is_null($translatorId)){
        $this->Translator->validator()->remove('email');
        $this->Translator->create(Configure::read('AnonymousTranslator.Translator'));
        $this->Translator->save();
        $translatorId = $this->Translator->id;
        $this->Setting->put('AnonymousTranslator.id', $translatorId);
      }

      $tr = $this->Translation->add($this->request->data['text'], $this->request->data['requestId'], $translatorId);

      if($tr){
        $this->set('status', 0);
      }else{
        $this->set('status', 2);
        $this->set('errorMessage', 'Adding translation failed.');
      }
    }else{
      $this->set('status', 1);
      $this->set('errorMessage', 'Invalid input.');
    }
    $this->set('_serialize', array('status', 'errorMessage', 'translation'));
  }

  /*
  public function index() {
    $this->Translation->recursive = 0;
    $this->set('translations', $this->Paginator->paginate());
  }

  public function view($id = null) {
    if (!$this->Translation->exists($id)) {
      throw new NotFoundException(__('Invalid translation'));
    }
    $this->Post->recursive = 1;
    $options = array('conditions' => array('Translation.' . $this->Translation->primaryKey => $id));
    $this->set('translation', $this->Translation->find('first', $options));
  }
  */

}

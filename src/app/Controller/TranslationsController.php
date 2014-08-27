<?php
App::uses('AppController', 'Controller');

class TranslationsController extends AppController {

  public $components = array('Paginator');

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

}

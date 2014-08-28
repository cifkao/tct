<?php
App::uses('AppController', 'Controller');

class PostsController extends AppController {

  public $components = array('Paginator');

  public function index() {
    $this->Post->recursive = 2;
    $this->set('posts', $this->Paginator->paginate());
  }

  public function view($id = null) {
    if (!$this->Post->exists($id)) {
      throw new NotFoundException(__('Invalid post'));
    }
    $options = array(
      'conditions' => array('Post.' . $this->Post->primaryKey => $id)
    );
    $this->Post->recursive = 2;
    $this->set('post', $this->Post->find('first', $options));
  }

}

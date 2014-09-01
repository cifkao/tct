<?php
App::uses('AppController', 'Controller');

class AdminsController extends AppController {

  public function admin_login() {
    if ($this->request->is('post')) {
      if ($this->Auth->login()) {
        return $this->redirect($this->Auth->redirect());
      }
      $this->Session->setFlash(__('Invalid username or password, try again'));
    }
  }

  public function admin_logout() {
    return $this->redirect($this->Auth->logout());
  }

}

<?php
App::uses('AppController', 'Controller');
App::uses('Mail', 'Utility');

class TranslatorsController extends AppController {
  public $scaffold;
  public $uses = ['Translator', 'AuthToken'];
  public $components = ['RequestHandler', 'Paginator', 'Session'];


  public function register(){
    if($this->request->is('post')){
      $email = $this->request->data['Translator']['email'];
      if($this->Translator->existsWithEmail($email)){
        $this->Session->setFlash(__("E-mail already registered."));
        return;
      }

      $this->Translator->create();
      $success = $this->Translator->save($this->request->data, [
        'fieldList' => ['email', 'name', 'description']
      ]);
      if($success){
        $tokenData = $this->AuthToken->getByTranslator($this->Translator->id);
      }

      if(!$success || !$tokenData){
        $this->Session->setFlash(__("Registration failed."));
        return;
      }

      $error = Mail::send(
        $email,
        __("TCT Registration"),
        __("Thank you for signing up as a translator on TCT. " .
        "Please confirm your registration by following this link:\n" .
        "%s",
        Router::url(['action' => 'activate', $tokenData['AuthToken']['hash']], true)
      ));

      if($error==null){
        $this->Session->setFlash(__("Confirmation e-mail sent."));
      }else{
        $this->Session->setFlash(__("Sending e-mail failed: %s.", $error));
      }
      return $this->redirect(['action' => 'index']);
    }
  }

  public function activate($hash = null){
    if(!$hash){
      $this->Session->setFlash(__("Activation failed: missing token."));
      return $this->redirect(['action' => 'index']);
    }
    
    $this->AuthToken->contain('Translator');
    $data = $this->AuthToken->findByHash($hash);
    pr($data);
    if(!$data || !$data['Translator'] || $data['Translator']['activated']){
      $this->AuthToken->delete();
      $this->Session->setFlash(__("Activation failed: invalid token."));
      return $this->redirect(['action' => 'index']);
    }

    $this->Translator->id = $data['Translator']['id'];
    $this->Translator->saveField('activated', true);
    $this->Session->setFlash(__("Account activated."));
    return $this->redirect(['action' => 'edit_settings', $hash]);
  }

  public function edit_settings($hash = null){
    // No hash => ask for e-mail
    if(!$hash){
      $this->render('request_settings');
      return;
    }

    // Hash passed => get translator data
    $this->AuthToken->contain('Translator');
    $tokenData = $this->AuthToken->findByHash($hash);
    $this->AuthToken->id = $tokenData['AuthToken']['id'];
    if(!$tokenData || !$tokenData['Translator']){
      $this->AuthToken->delete();
      $this->Session->setFlash(__("Request failed: invalid token."));
      return $this->redirect(['action' => 'edit_settings']); // will render request_settings
    }
    if(!$tokenData['Translator']['activated'])
      return $this->redirect(['action' => 'activate', $hash]);


    // Data passed => save it, destroy token
    if($this->request->is(['post', 'put'])){
      $res = $this->Translator->save($this->request->data, [
        'fieldList' => ['name', 'description', 'vacation', 'SrcLang', 'TgtLang']
      ]);
      if($res) {
        $this->AuthToken->delete();
				$this->Session->setFlash(__("Your settings have been saved."));
				return $this->redirect(['action' => 'view', $this->Translator->id]);
			} else {
				$this->Session->setFlash(__("Your settings could not be saved. Please, try again."));
			}
    }else{
      $this->Translator->contain(['SrcLang', 'TgtLang']);
      $this->request->data = $this->Translator->findById($tokenData['Translator']['id']);
    }

    // generate list of available languages (needed by form)
    $langs = $this->Translator->SrcLang->find('list');
    $this->set(['srcLangs' => $langs, 'tgtLangs' => $langs]);
  }

  public function request_settings(){
    if($this->request->is('post')){
      $email = $this->request->data['Translator']['email'];
      $data = $this->Translator->findByEmail($email);
      if(!$data){
        $this->Session->setFlash(__("The e-mail address you entered is not registered."));
        return;
      }

      if(!$data['Translator']['activated']){
        $this->Session->setFlash(__("Activate your account before changing your settings."));
        return;
      }

      $tokenData = $this->AuthToken->getByTranslator($data['Translator']['id']);

      $error = Mail::send(
        $data['Translator']['email'],
        __("TCT Settings Change"),
        __("To change your settings, follow this link:\n" .
        "%s",
        Router::url(['action' => 'edit_settings', $tokenData['AuthToken']['hash']], true)
      ));
      if($error==null){
        $this->Session->setFlash(__("E-mail sent."));
      }else{
        $this->Session->setFlash(__("Sending e-mail failed: %s.", $error));
      }
    }
    return $this->redirect(['action' => 'edit_settings']);
  }

}

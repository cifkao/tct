<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Admin extends AppModel {

  public $actsAs = array('Containable');

  public $validate = array(
    'username' => array(
      'required' => array(
        'rule' => array('notEmpty')
      )
    ),
    'password' => array(
      'required' => array(
        'rule' => array('notEmpty')
      )
    )
  );

  public function beforeSave($options = array()) {
    if (isset($this->data[$this->alias]['password'])) {
      $passwordHasher = new BlowfishPasswordHasher();
      $this->data[$this->alias]['password'] = $passwordHasher->hash(
        $this->data[$this->alias]['password']
      );
    }
    return true;
  }

}

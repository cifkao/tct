<?php
App::uses('AppModel', 'Model');

class Scoring extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Translation' => array(
      'counterCache' => true,
      'counterScope' => array(
        'NOT' => array('Scoring.result' => null)
      )
    )
  );

  public $validate = array(
    'result' => array(
      'rule' => array('inclusiveRange', 0, 1)
    )
  );


  public function add($data){
    $hash = md5($data['Translation']['text'] . $data['Post']['id'] . mt_rand());
    $userHash = $this->getUserHash();
  
    $this->create(array(
      'translation_id' => $data['Translation']['id'],
      'hash' => $hash,
      'user_hash' => $userHash
    ));
    return $this->save(null, false);
  }

  public function getUserHash(){
    return md5(env('HTTP_USER_AGENT') . env('REMOTE_ADDR'));
  }

}

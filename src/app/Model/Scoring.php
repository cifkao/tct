<?php
App::uses('AppModel', 'Model');

class Scoring extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Translation' => array(
      'conditions' => array(
        'NOT' => array('Scoring.result' => null)
      ),
      'counterCache' => true
    )
  );

  public $validate = array(
    'result' => array(
      'rule' => array('inclusiveRange', 0, 1)
    )
  );


  public function add($data){
    $hash = md5($data['Translation']['text'] . $data['Post']['id'] . mt_rand());
    $userHash = md5(env('HTTP_USER_AGENT') . env('REMOTE_ADDR'));
  
    $this->create(array(
      'translation_id' => $data['Translation']['id'],
      'hash' => $hash,
      'user_hash' => $userHash
    ));
    return $this->save(null, false);
  }

}

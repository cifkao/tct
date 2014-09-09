<?php
class Scoring extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Translation' => array(
      'className' => 'Translation'
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
    return $this->save();
  }

}

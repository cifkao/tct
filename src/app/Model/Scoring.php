<?php
class Scoring extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'TranslationA' => array(
      'className' => 'Translation'
    ),
    'TranslationB' => array(
      'className' => 'Translation'
    )
  );

  public $validate = array(
    'result' => array(
      'rule' => array('inList', array('a', 'b'))
    )
  );


  public function add($data){
    $hash = md5($data['TranslationA']['text'] . $data['TranslationB']['text'] . $data['Post']['id'] . mt_rand());
    $userHash = md5(env('HTTP_USER_AGENT') . env('REMOTE_ADDR'));
  
    $this->create(array(
      'translation_a_id' => $data['TranslationA']['id'],
      'translation_b_id' => $data['TranslationB']['id'],
      'hash' => $hash,
      'user_hash' => $userHash
    ));
    return $this->save();
  }

}

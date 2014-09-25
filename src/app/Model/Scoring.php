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


  public function afterSave($created, $options = array()) {
    parent::afterSave($created, $options);

    if(array_key_exists('result', $this->data[$this->alias]) && !is_null($this->data[$this->alias]['result'])){
      $scoring = $this->read();
      if(!$scoring[$this->alias]['skipped']){
        $this->virtualFields['avg_result'] = 'AVG(result)';
        $scoring = $this->find('all', array(
          'conditions' => array(
            'translation_id' => $scoring[$this->alias]['translation_id'],
            'skipped' => false,
            'NOT' => array('result' => null)
          ),
          'group' => 'translation_id'
        ));
        $this->Translation->save(array(
          'id' => $scoring[0][$this->alias]['translation_id'],
          'avg_score' => $scoring[0][$this->alias]['avg_result']
        ));
        unset($this->virtualFields['avg_result']);
      }
    }
  }

}

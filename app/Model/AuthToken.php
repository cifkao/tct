<?php
App::uses('Security', 'Utility');

class AuthToken extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Translator' => array(
      'foreignKey' => false,
      'conditions' => array('Translator.id = AuthToken.translator_id')
    )
  );


  /**
   * Get an AuthToken for a given Translator. If the translator doesn't have a token, create it.
   */
  public function getByTranslator($translatorId){
    $data = $this->findByTranslatorId($translatorId);
    $this->log($data);
    if(!$data){
      $this->create(array(
        'hash' => Security::generateAuthKey(),
        'translator_id' => $translatorId
      ));
      $data = $this->save();
    }
    return $data;
  }

}

<?php
App::uses('Security', 'Utility');

class AuthToken extends AppModel {
  public $actsAs = ['Containable'];

  public $belongsTo = [
    'Translator' => [
      'foreignKey' => false,
      'conditions' => array('Translator.id = AuthToken.translator_id')
    ]
  ];


  /**
   * Get an AuthToken for a given Translator. If the translator doesn't have a token, create it.
   */
  public function getByTranslator($translatorId){
    $data = $this->findByTranslatorId($translatorId);
    $this->log($data);
    if(!$data){
      $this->create([
        'hash' => Security::generateAuthKey(),
        'translator_id' => $translatorId
      ]);
      $data = $this->save();
    }
    return $data;
  }

}

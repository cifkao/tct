<?php
class Translator extends AppModel {
  public $actsAs = ['Containable'];

  public $hasMany = [
    'AuthToken' =>[
      'dependent' => true
    ]
  ];

  public $hasAndBelongsToMany = [
    'SrcLang' => [
      'className' => 'Lang',
      'joinTable' => 'translators_src_langs'
    ],
    'TgtLang' => [
      'className' => 'Lang',
      'joinTable' => 'translators_tgt_langs'
    ]
  ];

  public $validate = [
    'email' => ['rule' => 'email', 'required' => true]
  ];

  public $displayField = 'email';

  
  /**
   * Finds out whether a Translator with the given e-mail is already registered.
   */
  public function existsWithEmail($email){
    return $this->find('count', [
      'conditions' => ['Translator.email' => $email]
    ])>0;
  }

}

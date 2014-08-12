<?php
class Translator extends AppModel {
  public $actsAs = array('Containable');

  public $hasMany = array(
    'AuthToken' => array(
      'dependent' => true
    )
  );

  public $hasAndBelongsToMany = array(
    'SrcLang' => array(
      'className' => 'Lang',
      'joinTable' => 'translators_src_langs'
    ),
    'TgtLang' => array(
      'className' => 'Lang',
      'joinTable' => 'translators_tgt_langs'
    )
  );

  public $validate = array(
    'email' => array('rule' => 'email', 'required' => true)
  );

  public $displayField = 'email';

  
  /**
   * Finds out whether a Translator with the given e-mail is already registered.
   */
  public function existsWithEmail($email) {
    return $this->find('count', array(
      'conditions' => array('Translator.email' => $email)
    ))>0;
  }

  /**
   * Finds all translators that can translate from $srcLangId to $tgtLangId.
   */
  public function findByLangs($srcLangId, $tgtLangId, $activeOnly = true) {
    $conditions = array(
      'TranslatorsSrcLang.lang_id' => $srcLangId,
      'TranslatorsTgtLang.lang_id' => $tgtLangId,
    );
    if($activeOnly){
      $conditions['Translator.activated'] = true;
      $conditions['Translator.vacation'] = false;
    }

    $this->bindModel(array('hasOne' => array('TranslatorsSrcLang', 'TranslatorsTgtLang')));
    return $this->find('all', array(
      'contain' => array('TranslatorsSrcLang', 'TranslatorsTgtLang'),
      'conditions' => $conditions
    ));
  }

}

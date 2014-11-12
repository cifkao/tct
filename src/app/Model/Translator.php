<?php
class Translator extends AppModel {
  public $actsAs = array('Containable');

  public $hasMany = array(
    'AuthToken' => array(
      'dependent' => true
    ),
    'Translation' => array(
      'dependent' => false
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
    'email' => array(
      'isUnique' => array(
        'rule' => 'isUnique',
      ),
      'email' => array(
        'rule' => 'email',
        'required' => true
      ),
    ),
    'name' => array(
      'notEmpty' => array(
        'rule' => 'notEmpty',
        'required' => true
      )
    )
  );

  public $displayField = 'email';


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

  /**
   * Registers a new (inactive) translator.
   */
  public function registerEmail($email){
    $this->create();
    $this->validator()->remove('name');
    return $this->save(array('email' => $email));
  }

}

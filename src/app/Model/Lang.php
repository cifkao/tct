<?php
class Lang extends AppModel {

  public $actsAs = array('Containable');

  public $hasAndBelongsToMany = array(
    'SrcTranslator' => array(
      'className' => 'Translator',
      'joinTable' => 'translators_src_langs'
    ),
    'TgtTranslator' => array(
      'className' => 'Translator',
      'joinTable' => 'translators_tgt_langs'
    )
  );

  public $displayField = 'name';


  public function toId($idOrCode){
    $data = $this->findByIdOrCode($idOrCode, $idOrCode);
    return $data ? $data[$this->alias]['id'] : null;
  }

  public function toCode($idOrCode){
    $data = $this->findByIdOrCode($idOrCode, $idOrCode);
    return $data ? $data[$this->alias]['code'] : null;
  }

}

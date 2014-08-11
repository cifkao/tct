<?php
class Post extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'SrcLang' => array(
      'className' => 'Lang',
    ),
    'TgtLang' => array(
      'className' => 'Lang',
    )
  );

  public $hasMany = array(
    'TwitterPost' => array(
      'foreignKey' => 'id',
      'dependent' => true
    )
  );

  public $validate = array(
    'hash' => 'isUnique'
  );

  public function add($text, $srcLangId, $tgtLangId, $hash){
    $this->create();
    return $this->save(array(
      'text' => $text,
      'src_lang_id' => $srcLangId,
      'tgt_lang_id' => $tgtLangId,
      'hash' => $hash
    ));
  }

}

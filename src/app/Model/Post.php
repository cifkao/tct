<?php
class Post extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Lang'
  );

  public $hasMany = array(
    'TranslationRequest' => array(
      'dependent' => true
    ),
    'Translation' => array(
      'dependent' => true
    ),
    'TwitterPost' => array(
      'foreignKey' => 'id',
      'dependent' => true
    )
  );

  public function add($text, $langId){
    $this->create();
    $data = $this->save(array(
      'text' => $text,
      'lang_id' => $langId
    ));

    return $data;
  }

}

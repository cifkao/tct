<?php
App::uses('Translator', 'Model');
App::uses('Lang', 'Model');

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
    'Translation' => array(
      'dependent' => true
    ),
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
    $data = $this->save(array(
      'text' => $text,
      'src_lang_id' => $srcLangId,
      'tgt_lang_id' => $tgtLangId,
      'hash' => $hash
    ));

    if($data){
      $Lang = new Lang();
      $srcLang = $Lang->findById($srcLangId);
      $tgtLang = $Lang->findById($tgtLangId);

      // notify translators
      $Translator = new Translator();
      $translators = $Translator->findByLangs($srcLangId, $tgtLangId);
      $to = array();
      foreach($translators as $data){
        array_push($to, $data['Translator']['email']);
      }

      $Mail = new Mail();
      $Mail->send(
        $to,
        __("TCT Request For Translation"),
        __("Please translate the following post to language: %s\n\n" .
        "%s\n\n" .
        "ID:%s",
        __($tgtLang['Lang']['name']),
        $text,
        $hash
      ));
    }

    return $data;
  }

}

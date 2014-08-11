<?php
class Lang extends AppModel {

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

  public $displayField = 'code';
}

<?php
class Lang extends AppModel {

  public $hasAndBelongsToMany = [
    'SrcTranslator' => [
      'className' => 'Translator',
      'joinTable' => 'translators_src_langs'
    ],
    'TgtTranslator' => [
      'className' => 'Translator',
      'joinTable' => 'translators_tgt_langs'
    ]
  ];

  public $displayField = 'code';
}

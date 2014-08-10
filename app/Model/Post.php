<?php
class Post extends AppModel {
  public $actsAs = ['Containable'];

  public $belongsTo = [
    'SrcLang' => [
      'className' => 'Lang',
    ],
    'TgtLang' => [
      'className' => 'Lang',
    ]
  ];

}

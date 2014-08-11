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

}

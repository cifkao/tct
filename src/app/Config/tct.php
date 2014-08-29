<?php
$config = array(
  'MT' => array(
    'url' => 'http://cuni1-khresmoi.ms.mff.cuni.cz:8080/khresmoi',
    'lang_pairs' => array(
      'en' => array('cs' => true, 'de' => true, 'fr' => true),
      'cs' => array('en' => true),
      'de' => array('en' => true),
      'fr' => array('en' => true)
    ),
    'Translator' => array(
      'email' => 'twittercrowdtranslation@gmail.com',
      'name' => 'Moses',
      'activated' => true
    )
  ),
  'Scoring' => array(
    'accept_threshold' => 1500,
    'default' => 1400
  ),
  'Design' => array(
    'score_alert' => 90,
    'score_secondary' => 50
  )
);

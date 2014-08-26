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
      'name' => 'MTMonkey',
      'activated' => true
    )
  ),
  'Scoring' => array(
    'accept_threshold' => 1500
  )
);

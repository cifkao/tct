<?php
$config = array(
  'MT' => array(
    'lang_pairs' => array(
      'en' => array('cs' => true, 'de' => true, 'fr' => true),
      'cs' => array('en' => true),
      'de' => array('en' => true),
      'fr' => array('en' => true),
      'uk' => array('cs' => true),
      'ru' => array('cs' => true),
      'ar' => array('en' => true)
    ),
    'Translator' => array(
      'email' => 'twittercrowdtranslation@gmail.com',
      'name' => 'Moses',
      'activated' => true
    )
  ),
  'Scoring' => array(
    'accept_threshold' => 1500,
    'default' => 1400,
    'both_bad_winner_score' => 1400,
    'timeout' => 10*60 /* 10 minutes */
  ),
  'Design' => array(
    'score_alert' => 90,
    'score_secondary' => 50
  ),
  'AuthToken' => array(
    'timeout' => 24*60*60 /* 24 hours */
  )
);

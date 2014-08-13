<?php
App::uses('Mail', 'Utility');

class TwitterPost extends AppModel {
  public $useTable = 'posts_twitter';
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Post' => array(
      'foreignKey' => 'id'
    )
  );

  /**
   * Submit the given tweet for translation. If no target language is
   * given, try to find a hashtag with the target language.
   */
  public function add($tweet, $notifyTranslators=true, $tgtLang=null){
    $isTctrq = is_null($tgtLang);

    $hash = md5($tweet['text'] . $tweet['id_str']);

    $tgtLangId = null;
    if($tgtLang){
      if($data = $this->Post->TgtLang->findByCodeOrId($tgtLang, $tgtLang))
        $tgtLangId = $data['TgtLang']['id'];
      else return null;
    }

    // get the list of all languages in the form [code] => id
    $langs = $this->Post->TgtLang->find('list', array(
      'fields' => array('code', 'id')
    ));

    if($isTctrq){
      // build an array of hashtags
      $hashtags = array();
      foreach ($tweet["entities"]["hashtags"] as $hashtag){
        array_push($hashtags, strtolower($hashtag["text"]));
      }
      // filter hashtags
      $langHashtags = array_values(array_intersect($hashtags, array_keys($langs)));
      if(!empty($langHashtags))
        $tgtLangId = $langs[$langHashtags[0]];
      else return null;
    }

    // check if src language known
    if(!array_key_exists($tweet['lang'], $langs))
      return null;
    $srcLangId = $langs[$tweet['lang']];

    // add tweet to database
    $data = null;
    if($srcLangId && $tgtLangId){
      $data = $this->Post->add($tweet['text'], $srcLangId, $tgtLangId, $hash, $notifyTranslators);
      if($data){
        $this->create(array(
          'id' => $this->Post->id,
          'tweet_id' => $tweet['id_str'],
          'author_id' => $tweet['user']['id_str'],
          'author_screen_name' => $tweet['user']['screen_name']
        ));
        $data = array_merge($data, $this->save());

        if($isTctrq){
          // notify author
          $twitter = new Twitter();
          $twitter->sendPrivateMessage($tweet['user']['id_str'],
            __("We have listed your request for translation.\n" .
            "More at:\n%s",
            Router::url(array('controller' => 'posts', 'action' => 'view', $this->Post->id), true)));
        }
      }
    }

    return $data;
  }

}

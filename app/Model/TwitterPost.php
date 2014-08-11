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

  public function add($tweet){
    $hash = md5($tweet['text'] . $tweet['id_str']);

    // build an array of hashtags
    $hashtags = array();
    foreach ($tweet["entities"]["hashtags"] as $hashtag){
  		array_push($hashtags, strtolower($hashtag["text"]));
    }
    // get the list of all languages in the form [code] => id
    $langs = $this->Post->SrcLang->find('list', array(
      'fields' => array('code', 'id')
    ));
    // filter hashtags
    $langHashtags = array_values(array_intersect($hashtags, array_keys($langs)));

    $srcLangId = $langs[$tweet['lang']];
    $tgtLangId = $langs[$langHashtags[0]];

    // add tweet to database
    $postData = null;
    if(!empty($langHashtags) && array_key_exists($tweet['lang'], $langs)){
      $postData = $this->Post->add($tweet['text'], $srcLangId, $tgtLangId, $hash);
      if($postData){
        $this->create(array(
          'id' => $this->Post->id,
          'tweet_id' => $tweet['id_str'],
          'author_id' => $tweet['user']['id_str'],
          'author_screen_name' => $tweet['user']['screen_name']
        ));
        $postData = array_merge($postData, $this->save());

        // notify author
        $twitter = new Twitter();
        $twitter->sendPrivateMessage($tweet['user']['id_str'],
          __("We have listed your request for translation.\n" .
          "More at:\n%s",
          Router::url(array('controller' => 'posts', 'action' => 'view', $this->Post->id), true)));
      }
    }

    return $postData;
  }

}

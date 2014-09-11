<?php
App::uses('Mail', 'Utility');
App::uses('CakeTime', 'Utility');
App::uses('TranslationRequest', 'Model');

class TwitterPost extends AppModel {
  public $useTable = 'posts_twitter';
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Post' => array(
      'foreignKey' => 'id'
    )
  );

  public $validate = array(
    'tweet_id' => 'isUnique'
  );

  /**
   * Submit the given tweet for translation. If no target language is
   * given, try to find a hashtag with the target language.
   */
  public function add($tweet, $isTctrq=false, $notifyTranslators=true){
    // get the list of all languages in the form [code] => id
    $langs = $this->Post->Lang->find('list', array(
      'fields' => array('code', 'id')
    ));

    // add original tweet instead of retweet
    $retweet = null;
    if(array_key_exists('retweeted_status', $tweet) && !is_null($tweet['retweeted_status'])){
      $retweet = $tweet;
      $tweet = $tweet['retweeted_status'];
    }

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
      // TODO: remove #tctrq and lang hashtags from the post?
    }

    // check if src language known
    if(!array_key_exists($tweet['lang'], $langs))
      return null;
    $srcLangId = $langs[$tweet['lang']];

    // add tweet to database
    $data = null;
    if($srcLangId){
      $data = $this->Post->add(html_entity_decode($tweet['text']), $srcLangId);
      if($data){
        $this->create(array(
          'id' => $this->Post->id,
          'tweet_id' => $tweet['id_str'],
          'author_id' => $tweet['user']['id_str'],
          'author_screen_name' => $tweet['user']['screen_name'],
          'created' => CakeTime::format(CakeTime::fromString($tweet['created_at']), "%Y-%m-%d %H:%M:%S")
        ));
        if(!is_null($retweet))
          $this->data[$this->alias]['retweet_id'] = $retweet['id_str'];
        $tweetData = $this->save();
        if(!$tweetData){
          $this->Post->delete();
          return null;
        }

        $data = array_merge($data, $tweetData);

        if($isTctrq){
          $TrRequest = new TranslationRequest();
          $TrRequest->add($this->Post->id, $tgtLangId, $notifyTranslators);

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

<?php
App::uses('Twitter', 'Utility');
class TwitterShell extends AppShell {

  public $uses = array('Setting', 'TwitterPost', 'Post', 'TranslationRequest');

  protected $Twitter;

  public function initialize(){
    $this->Twitter = new Twitter();
  }

  public function addTweet(){
    $notifyTranslators = !$this->params['no-spam'];
    $id = $this->args[0];
    $tweet = $this->Twitter->getTweet($id);

    if(!$tweet || array_key_exists('errors', $tweet)){
      $this->out('<error>Error:</error> ' . $tweet['errors'][0]['message']);
      return;
    }

    $data = $this->TwitterPost->add($tweet, $this->params['tctrq'], $notifyTranslators);
    if($data){
      $this->out("<info>OK:</info> Added Tweet {$data['TwitterPost']['tweet_id']} " .
        "(lang:$tweet[lang],user:{$data['TwitterPost']['author_screen_name']}) " .
          "as Post #{$data['TwitterPost']['id']}.");
    }else{
      $this->out('<error>Error:</error> Failed to add tweet.');
    }
  }

  public function pull(){
    $notifyTranslators = !$this->params['no-spam'];
    $sinceId = $this->Setting->getString('Twitter.timeline.newest_seen', null);

    $tweets = $this->Twitter->getTimeline(200, $sinceId);
    if(is_null($tweets) || array_key_exists('errors', $tweets)){
      if(!is_null($tweets))
        $this->out('<error>Error:</error> ' . $tweets['errors'][0]['message']);
      else
        $this->out('<error>Error:</error> Failed to retrieve Tweets.');
      return;
    }

    if(count($tweets)>0)
      $this->Setting->put('Twitter.timeline.newest_seen', $tweets[0]['id_str']);

    $myUserId = Configure::read('Twitter.user_id_str');
    foreach($tweets as $tweet){
      if($tweet['user']['id_str']==$myUserId)
        continue;

      $data = $this->TwitterPost->add($tweet, false, $notifyTranslators);
      if($data){
        if(count($this->args)>0){
          $langs = explode(',', $this->args[0]);
          foreach($langs as $lang){
            $this->TranslationRequest->add($data['TwitterPost']['id'], $lang, $notifyTranslators);
          }
        }
        $this->out("<info>OK:</info> Added Tweet $tweet[id_str] (lang:$tweet[lang],user:{$tweet['user']['screen_name']}) " .
          "as Post #{$data['TwitterPost']['id']}.");
      }else{
        $this->out("<warning>Warning:</warning> " .
          "Tweet $tweet[id_str] (lang:$tweet[lang],user:{$tweet['user']['screen_name']}) has not been added.");
      }
    }
  }

  public function dump(){
    $data = $this->TwitterPost->find('all', array('contain' => array('Post' => array('Lang'))));
    foreach($data as $d){
      $this->out($d['Post']['Lang']['code'] . " " . $d['TwitterPost']['tweet_id'] . " " . preg_replace('/\s+/', ' ', $d['Post']['text']));
    }
  }


  public function get(){
    $data = explode('?', $this->args[0], 2);
    if(count($data)>1)
      $this->out(json_encode($this->Twitter->get($data[0], '?' . $data[1]), JSON_PRETTY_PRINT));
    else
      $this->out(json_encode($this->Twitter->get($data[0]), JSON_PRETTY_PRINT));
  }


  public function getOptionParser() {
    $parser = parent::getOptionParser();
    $parser->addSubcommand('pull', array(
      'help' => 'Get new tweets from everyone we follow and submit them for translation.',
      'parser' => array(
        'arguments' => array(
          'langs' => array('help'=> 'A comma-separated list of target languages.')
        ),
        'options' => array(
          'no-spam' => array('short' => 'n', 'help' => 'Don\'t notify translators.', 'boolean' => true)
        )
      )
    ))->addSubcommand('addTweet', array(
      'help' => 'Add the tweet with the given id.',
      'parser' => array(
        'arguments' => array(
          'id' => array('help' => 'The id of the tweet.', 'required' => true)
        ),
        'options' => array(
          'tctrq' => array('short' => 'h', 'help' => 'Use hashtags to determine the target language.', 'boolean' => true),
          'no-spam' => array('short' => 'n', 'help' => 'Don\'t notify translators.', 'boolean' => true)
        )
      )
    ))->addSubcommand('dump', array(
      'help' => 'Dumps all the tweets in the database.',
    ))->addSubcommand('get', array(
      'help' => 'Send an arbitrary GET request and show the result.',
    ));
    return $parser;
  }

}

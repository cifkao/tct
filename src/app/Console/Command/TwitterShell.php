<?php
App::uses('Twitter', 'Utility');
class TwitterShell extends AppShell {

  public $uses = array('Setting', 'TwitterPost');

  protected $Twitter;

  public function initialize(){
    $this->Twitter = new Twitter();
  }

  public function addTweet(){
    $id = $this->args[0];
    $notifyTranslators = !$this->params['no-spam'];
    $tweet = $this->Twitter->getTweet($id);

    if(!$tweet || array_key_exists('errors', $tweet)){
      $this->out('<error>Error:</error> ' . $tweet['errors'][0]['message']);
      return;
    }

    if(count($this->args)>1){
      $data = $this->TwitterPost->add($tweet, $notifyTranslators, $this->args[1]);
    }else{
      $data = $this->TwitterPost->add($tweet, $notifyTranslators);
    }

    if(!$data)
      $this->out('<error>Error:</error> Failed to add tweet.');
  }

  public function pull(){
    $tgtLang = $this->args[0];
    $notifyTranslators = !$this->params['no-spam'];
    $sinceId = $this->Setting->getString('Twitter.timeline.newest_seen', null);

    $tweets = $this->Twitter->getTimeline(200, $sinceId);
    if(!$tweets || array_key_exists('errors', $tweets)){
      $this->out('<error>Error:</error> ' . $tweets['errors'][0]['message']);
      return;
    }

    $myUserId = Configure::read('Twitter.user_id_str');
    foreach($tweets as $tweet){
      if($tweet['user']['id_str']==$myUserId)
        continue;

      $data = $this->TwitterPost->add($tweet, $notifyTranslators, $tgtLang);
      if($data)
        $this->out("<info>Added</info> Tweet $tweet[id_str] (lang:$tweet[lang],user:{$tweet['user']['screen_name']}).");
      else
        $this->out("<warning>Warning:</warning> " .
          "Tweet $tweet[id_str] (lang:$tweet[lang],user:{$tweet['user']['screen_name']}) has not been added.");
    }

    if(count($tweets)>0)
      $this->Setting->put('Twitter.timeline.newest_seen', $tweets[0]['id_str']);
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
    $parser->addSubcommand('addTweet', array(
      'help' => 'Submit the tweet with the given id for translation.',
      'parser' => array(
        'arguments' => array(
          'id' => array('help' => 'The id of the tweet.', 'required' => true),
          'lang' => array('help'=> 'The target language.')
        ),
        'options' => array(
          'no-spam' => array('short' => 'n', 'help' => 'Don\'t notify translators.', 'boolean' => true),
        )
      )
    ))->addSubcommand('pull', array(
      'help' => 'Get new tweets from everyone we follow and submit them for translation.',
      'parser' => array(
        'arguments' => array(
          'lang' => array('help'=> 'The target language.', 'required' => true)
        ),
        'options' => array(
          'no-spam' => array('short' => 'n', 'help' => 'Don\'t notify translators.', 'boolean' => true)
        )
      )
    ))->addSubcommand('get', array(
      'help' => 'Send an arbitrary GET request and show the result.',
    ));
    return $parser;
  }

}

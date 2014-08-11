<?php
App::uses('Twitter', 'Utility');
class TwitterShell extends AppShell {

  public $uses = array('TwitterPost');

  protected $Twitter;

  public function initialize(){
    $this->Twitter = new Twitter();
  }

  public function addTweet(){
    $id = $this->args[0];
    $data = $this->TwitterPost->add($this->Twitter->getTweet($id));
    if(!$data)
      $this->out(__('<error>Error:</error> Failed to add tweet.'));
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
      'help' => 'Adds a tweet with the given id to the database.',
    ))->addSubcommand('get', array(
      'help' => 'Sends an arbitrary GET request and shows the result.'
    ));
    return $parser;
  }

}

<?php
App::import('Vendor', 'TwitterAPIExchange',
  array('file' => 'twitter'.DS.'TwitterAPIExchange.php'));
Configure::load("twitter", "default");

class Twitter {

  public $API;

  protected $apiUrl = "https://api.twitter.com/1.1/";

  public function __construct(){
    $this->API = new TwitterAPIExchange(Configure::read("Twitter.auth"));
  }

  public function getTweet($id){
    $url = $this->apiUrl . "statuses/show.json";
    $res = $this->API->setGetfield("?id=".$id)
                     ->buildOauth($url, 'GET')
                     ->performRequest();
    return json_decode($res, $assoc = true);
  }

  public function sendPrivateMessage($userId, $text){
    $url = $this->apiUrl . "direct_messages/new.json";
    $this->API->setPostFields(array('user_id' => $userId, 'text' => $text))
              ->buildOauth($url, 'POST')
              ->performRequest();
  }


  public function get($url, $getfield=null){
    if($getfield)
      $res = $this->API->setGetfield($getfield);
    $res = $this->API->buildOauth($this->apiUrl . $url, 'GET')
                     ->performRequest();
    return json_decode($res, $assoc = true);
  }

}

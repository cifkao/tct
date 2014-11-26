<?php
App::import('Vendor', 'TwitterAPIExchange',
  array('file' => 'twitter'.DS.'TwitterAPIExchange.php'));

class Twitter {

  public $API;

  private $apiUrl = "https://api.twitter.com/1.1/";

  public function __construct(){
    $this->API = new TwitterAPIExchange(Configure::read("Twitter.auth"));
  }

  /**
   * Returns a single Tweet, specified by the id parameter.
   */
  public function getTweet($id){
    $url = $this->apiUrl . "statuses/show.json";
    $res = $this->API->setGetfield("?id=".$id)
                     ->buildOauth($url, 'GET')
                     ->performRequest();
    return json_decode($res, $assoc=true);
  }

  /**
   * Returns a collection of the most recent Tweets and retweets posted
   * by the authenticating user and the users they follow. 
   */
  public function getTimeline($count=20, $sinceId=null, $maxId=null, $trimUser=false, $excludeReplies=false){
    $url = $this->apiUrl . "statuses/home_timeline.json";
    $this->API->setGetField("?count=$count" .
      (!is_null($sinceId) ? "&since_id=$sinceId" : "") .
      (!is_null($maxId) ? "&max_id=$maxId" : "") .
      "&trim_user=$trimUser&exclude_replies=$excludeReplies");
    $res = $this->API->buildOauth($url, 'GET')->performRequest();
    return json_decode($res, $assoc=true);
  }

  /**
   * Sends a new direct message to the specified user from the authenticating user.
   */
  public function sendPrivateMessage($userId, $text){
    $url = $this->apiUrl . "direct_messages/new.json";
    $res = $this->API->setPostFields(array('user_id' => $userId, 'text' => $text))
                     ->buildOauth($url, 'POST')
                     ->performRequest();
    return json_decode($res, $assoc=true);
  }

  /**
   * Updates the authenticating user's current status, also known as tweeting.
   */
  public function tweet($text, $inReplyTo=null){
    $url = $this->apiUrl . "statuses/update.json";
    $res = $this->API->setPostFields(array('status' => $text, 'in_reply_to_status_id' => $inReplyTo))
                     ->buildOauth($url, 'POST')
                     ->performRequest();
    return json_decode($res, $assoc=true);
  }

  /**
   * Retweets a tweet.
   */
  public function retweet($id){
    $url = $this->apiUrl . "statuses/retweet/{$id}.json";
    $res = $this->API->setPostFields(array('id' => $id))
                     ->buildOauth($url, 'POST')
                     ->performRequest();
    return json_decode($res, $assoc=true);
  }
  

  public function get($url, $getfield=null){
    if($getfield)
      $res = $this->API->setGetfield($getfield);
    $res = $this->API->buildOauth($this->apiUrl . $url, 'GET')
                     ->performRequest();
    if($res)
      return json_decode($res, $assoc=true);
    else
      return null;
  }

}

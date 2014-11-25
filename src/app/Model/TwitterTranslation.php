<?php
App::uses('Twitter', 'Utility');
App::uses('Mail', 'Utility');
App::uses('CakeTime', 'Utility');
App::uses('Setting', 'Model');
App::import('Vendor', 'Twitter_Extractor',
  array('file' => 'twitter-text-php'.DS.'lib'.DS.'Twitter'.DS.'Extractor.php'));
App::import('Vendor', 'Twitter_Validation',
  array('file' => 'twitter-text-php'.DS.'lib'.DS.'Twitter'.DS.'Validation.php'));

class TwitterTranslation extends AppModel {
  public $useTable = 'translations_twitter';
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Translation' => array(
      'foreignKey' => 'id'
    )
  );

  public $validate = array(
    'tweet_id' => 'isUnique'
  );

  /**
   * Tweet the given translation.
   */
  public function post($translationId){
    $data = $this->Translation->find('first', array(
      'conditions' => array('Translation.id' => $translationId),
      'contain' => array('Post' => array('TwitterPost'))
    ));
    if(!$data || !$data['Post'] || !$data['Post']['TwitterPost'] || is_null($data['Post']['TwitterPost']['id'])) return false;

    $Setting = new Setting();
    if($Setting->getBoolean('Twitter.tweeting_enabled', true)){
      $twitter = new Twitter();

      $text = '.@' . $data['Post']['TwitterPost']['author_screen_name'] .' '. $data['Translation']['text'];

      // truncate to 140 characters
      $validator = new Twitter_Validation();
      $extractor = new Twitter_Extractor();
      $truncated = false;
      while($validator->getTweetLength($text)>140){
        $truncated = true;
        $urls = $extractor->extractURLsWithIndices($text);
        if(empty($urls)){
          $text = mb_substr($text, 0, 140-1);
          break;
        }else{
          $text = trim(mb_substr($text, 0, end($urls)['indices'][0]));
        }
      }
      if($truncated && $validator->getTweetLength($text)<=140-1){
        $text .= '…';
      }

      // retweet
      if($data['Post']['TwitterPost']['my_retweet_id'] == null){
        $retweet = $twitter->retweet($data['Post']['TwitterPost']['tweet_id']);
        if(!$retweet){
          $this->log('Retweet failed.');
        }else if(array_key_exists('errors', $retweet)){
          $this->log('Retweet failed: ' . $retweet['errors']);
        }else{
          $this->Translation->Post->TwitterPost->id = $data['Post']['TwitterPost']['id'];
          $this->Translation->Post->TwitterPost->saveField('my_retweet_id', $retweet['id_str']);
        }
      }

      // reply
      $tweet = $twitter->tweet($text, $data['Post']['TwitterPost']['tweet_id']);
      if(!$tweet){
        $this->log('Tweeting failed.');
        return false;
      }else if(array_key_exists('errors', $tweet)){
        $this->log('Tweeting failed: ' . $tweet['errors'][0]['message']);
        return false;
      }

      // save
      $this->create(array(
        'id' => $data['Translation']['id'],
        'tweet_id' => $tweet['id_str']
      ));
      $this->save();
    }
    
    return true;
  }

}

<?php
App::uses('AppModel', 'Model');

class Browser extends AppModel {
  public $actsAs = array('Containable');

  public function current(){
    $hash = $this->getCurrentHash();
    if(is_null($hash)) return null;

    $browser = $this->findByHash($hash);
    if(!$browser){
      $this->create(array(
        'hash' => $hash,
        'user_agent' => env('HTTP_USER_AGENT'),
        'ip_address' => env('REMOTE_ADDR')
      ));
      $browser = $this->save();
    }
  
    return $browser;
  }

  public function getCurrentHash(){
    return (env('HTTP_USER_AGENT') && env('REMOTE_ADDR')) ? md5(env('HTTP_USER_AGENT') . env('REMOTE_ADDR')) : null;
  }

}

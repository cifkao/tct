<?php
/**
 * A special model for settings (key/value pairs) that need
 * to be changed at run time (unlike Cake's Config).
 */
class Setting extends AppModel {

  public function put($key, $value){
    $data = $this->findByKey($key);
    if($data){
      $this->id = $data[$this->alias]['id'];
    }else{
      $this->create();
    }
    $this->save(array('key' => $key, 'value' => $value));
  }

  public function getString($key, $default=null){
    $data = $this->findByKey($key);
    if($data)
      return $data[$this->alias]['value'];
    else
      return $default;
  }

  public function getNumber($key, $default=null){
    $str = $this->getString($key, $default);
    if(is_null($str)) return $str;
    else return $str + 0;
  }

  public function getBoolean($key, $default=false){
    $bool = $this->getString($key, $default);
    if($bool===$default) return $default;
    else if(strtolower($bool)==='true') return true;
    else return false;
  }

}

<?php
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
    return $this->getString($key, $default) + 0;
  }

}

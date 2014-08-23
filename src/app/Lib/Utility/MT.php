<?php
class MT {

  public static function translate($sourceLang, $targetLang, $text){
    if(!Configure::read("MT.lang_pairs.$sourceLang.$targetLang"))
      return false;

    $url = Configure::read('MT.url');

    $params = array(
      "action" 		=> "translate",
      "sourceLang" 	=> $sourceLang,
      "targetLang" 	=> $targetLang,
      "text"			=> $text,
      "alignmentInfo"	=> "false"
    );

    $ch = curl_init($url);
    $opts = array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_HEADER => true,
      CURLOPT_HTTPHEADER => array('Content-Type: application/json; charset=utf-8'),
      CURLOPT_POSTFIELDS => json_encode($params)
    );
    curl_setopt_array($ch, $opts);
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    $headers = explode("\n", substr($response, 0, $info['header_size']));
    $body = substr($response, -$info['download_content_length']);

    if($info['http_code']==200){
      $data = json_decode($body, true);
      $text = "";
      $sep = "";
      foreach($data['translation'][0]['translated'] as $tr){
        $text .= $sep . $tr['text'];
        $sep = " ";
      }
      return $text;
    }else{
      $this->log("MTMonkey response:\n" . $response);
      return false;
    }
  }

}

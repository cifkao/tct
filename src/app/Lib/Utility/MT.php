<?php
class MT {

  public static function translate( $sourceLang, $targetLang, $text ){
    if(!Configure::read("MT.lang_pairs.$sourceLang.$targetLang"))
      return false;

    $input = array(
      "action" 		=> "translate",
      "sourceLang" 	=> urlencode( $sourceLang ),
      "targetLang" 	=> urlencode( $targetLang ),
      "text"			=> urlencode( $text ),
      "alignmentInfo"	=> "false"
    );

    $request = Configure::read('MT.url');
    $sep = "?";

    foreach ( $input as $key => $value ){
      $request.= $sep.$key."=".$value;
      $sep = "&";
    }

    $data = file_get_contents( $request );
    $data = json_decode( $data, TRUE );

    if ( $data["errorMessage"] != "OK" )
      return FALSE;

    return $data["translation"][0]["translated"][0]["text"];
  }

}

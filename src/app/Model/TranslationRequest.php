<?php
App::uses('Mail', 'Utility');
App::uses('Translator', 'Model');
class TranslationRequest extends AppModel {
  public $actsAs = array('Containable');

  public $belongsTo = array(
    'Post' => array(
      'dependent' => true
    ),
    'TgtLang' => array(
      'className' => 'Lang',
      'dependent' => true
    )
  );

  public $validate = array(
    'hash' => 'isUnique'
  );

  public function add($postId, $tgtLangId, $notifyTranslators=true){
    $tgtLangId = $this->TgtLang->findId($tgtLangId);

    if($this->findByPostIdAndTgtLangId($postId, $tgtLangId))
      return null;

    $post = $this->Post->findById($postId);

    $hash = md5($post['Post']['text'] . $tgtLangId . mt_rand());

    $this->create();
    $data = $this->save(array(
      'post_id' => $postId,
      'tgt_lang_id' => $tgtLangId,
      'hash' => $hash
    ));

    if($data && $notifyTranslators){
      $tgtLang = $this->TgtLang->findById($tgtLangId);

      $Translator = new Translator();
      $translators = $Translator->findByLangs($post['Post']['lang_id'], $tgtLangId);
      $to = array();
      foreach($translators as $t){
        array_push($to, $t['Translator']['email']);
      }

      $Mail = new Mail();
      $Mail->send(
        $to,
        __("TCT Request For Translation"),
        __("Please translate the following post to language: %s\n\n" .
        "%s\n\n" .
        "ID:%s",
        __($tgtLang['TgtLang']['name']),
        $post['Post']['text'],
        $hash
      ));
    }

    return $data;
  }

}

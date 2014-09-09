<?php
App::uses('Mail', 'Utility');
App::uses('MT', 'Utility');
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
    ),
    'AcceptedTranslation' => array(
      'className' => 'Translation'
    )
  );

  public $hasMany = array(
    'Translation'
  );

  public $validate = array(
    'hash' => 'isUnique'
  );

  public function add($postId, $tgtLangId, $notifyTranslators=true){
    $tgtLang = $this->TgtLang->findByIdOrCode($tgtLangId, $tgtLangId);

    if(!$tgtLang || $this->findByPostIdAndTgtLangId($postId, $tgtLang['TgtLang']['id']))
      return null;

    $this->Post->contain('Lang');
    $post = $this->Post->findById($postId);

    if($post['Lang']['id'] == $tgtLang['TgtLang']['id'])
      return null;

    $hash = md5($post['Post']['text'] . $tgtLang['TgtLang']['id'] . mt_rand());

    $this->create();
    $data = $this->save(array(
      'post_id' => $postId,
      'tgt_lang_id' => $tgtLang['TgtLang']['id'],
      'hash' => $hash
    ));

    if($data){
      // human translation
      if($notifyTranslators){
        $Translator = new Translator();
        $translators = $Translator->findByLangs($post['Post']['lang_id'], $tgtLang['TgtLang']['id']);
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

      // machine translation
      $mtText = MT::translate($post['Lang']['code'], $tgtLang['TgtLang']['code'], $post['Post']['text']);
      if($mtText){
        $mt = $Translator->findByEmail(Configure::read('MT.Translator.email'));
        if(!$mt){
          $Translator->create(Configure::read('MT.Translator'));
          $mt = $Translator->save();
        }
        if($mt){
          $this->Post->Translation->add($mtText, $data['TranslationRequest']['id'], $mt['Translator']['id']);
        }
      }
    }

    return $data;
  }

}

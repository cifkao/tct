<?php
App::uses('Mail', 'Utility');
class MailShell extends AppShell {

  public $uses = array('Translation', 'Translator', 'TranslationRequest', 'Post');

  protected $Mail;

  public function initialize(){
    $this->Mail = new Mail();
  }

  public function pullTranslations(){
    $ids = $this->Mail->listUnseen();
    foreach($ids as $id){
      $data = $this->Mail->pullTranslation($id);
      if(!$data) continue;

      $translator = $this->Translator->findByEmail($data['email']);
      $this->TranslationRequest->contain(array('Post'));
      $postData = $this->TranslationRequest->findByHash($data['hash']);
      if(!$translator || !$postData) continue;

      $this->Translation->add($data['text'], $postData['Post']['id'],
        $translator['Translator']['id'], $postData['TranslationRequest']['tgt_lang_id']);
    }
  }

  public function getOptionParser() {
    $parser = parent::getOptionParser();
    $parser->addSubcommand('pullTranslations', array(
      'help' => 'Check the inbox for new translations and add them to the database.',
    ));
    return $parser;
  }

}

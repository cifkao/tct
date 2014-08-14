<?php
class PostShell extends AppShell {

  public $uses = array('Post', 'TranslationRequest');

  public function translate(){
    $notifyTranslators = !$this->params['no-spam'];

    $data = $this->Post->findById($this->args[0]);
    if(!$data){
      $this->out("<error>Error:</error> Failed to retrieve post.");
      return;
    }

    $langs = explode(',', $this->args[1]);
    foreach($langs as $lang){
      $this->TranslationRequest->add($data['Post']['id'], $lang, $notifyTranslators);
    }
  }

  public function getOptionParser() {
    $parser = parent::getOptionParser();
    $parser->addSubcommand('translate', array(
      'help' => 'Submit the given posts for translation.',
      'parser' => array(
        'arguments' => array(
          'id' => array('help'=> 'The id of the post.', 'required' => true),
          'langs' => array('help'=> 'A comma-separated list of target languages.', 'required' => true)
        ),
        'options' => array(
          'no-spam' => array('short' => 'n', 'help' => 'Don\'t notify translators.', 'boolean' => true)
        )
      )
    ));
    return $parser;
  }

}

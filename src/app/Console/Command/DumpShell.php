<?php
class DumpShell extends AppShell {

  public $uses = array('TwitterPost', 'Post', 'TranslationRequest', 'Translation', 'Translator', 'Lang');

  public function tweets(){
    $data = $this->TwitterPost->find('all', array('contain' => array('Post' => array('Lang'))));
    foreach($data as $d){
      $this->out($d['Post']['Lang']['code'] . " " . $d['TwitterPost']['tweet_id'] . " " . preg_replace('/\s+/', ' ', $d['Post']['text']));
    }
  }

  public function parallel(){
    $srcLangId = $this->Lang->toId($this->args[0]);
    $tgtLangId = $this->Lang->toId($this->args[1]);
    
    $data = $this->TranslationRequest->find('all', array(
      'contain' => array('Translation'),
      'conditions' => array(
        'TranslationRequest.tgt_lang_id' => $tgtLangId,
      ),
      'joins' => array(
        array(
          'table' => 'posts',
          'alias' => 'Post',
          'conditions' => array(
            'Post.id = TranslationRequest.post_id',
            'Post.lang_id' => $srcLangId
          ),
          'type' => 'INNER'
        )
      )
    ));

    $mt = $this->Translator->findByEmail(Configure::read('MT.Translator.email'));

    foreach($data as $d){
      $post = $this->Post->findById($d['TranslationRequest']['post_id']);
      foreach($d['Translation'] as $tr){
        if($tr['translator_id'] != $mt['Translator']['id']){
          $this->out(
            $post['Post']['id'] ."\t".
            preg_replace('/\s+/', ' ', $post['Post']['text']) ."\t".
            $tr['id'] ."\t". preg_replace('/\s+/', ' ', $tr['text']) ."\t".
            $tr['score']
          );
        }
      }
    }
  }


}

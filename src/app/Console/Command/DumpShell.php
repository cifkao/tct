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

    $mt = $this->Translator->findByEmail(Configure::read('MT.Translator.email'));
    
    $data = $this->TranslationRequest->find('all', array(
      'fields' => array('TranslationRequest.*', 'Post.lang_id', 'Translation.*'),
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
        ),
        array(
          'table' => 'translations',
          'alias' => 'Translation',
          'conditions' => array(
            'Translation.translation_request_id = TranslationRequest.id',
            'not' => array('Translation.translator_id' => $mt['Translator']['id'])
          ),
          'type' => 'INNER'
        )
      )
    ));

    foreach($data as $d){
      $post = $this->Post->findById($d['TranslationRequest']['post_id']);
      //foreach($d['Translation'] as $tr){
      $tr = $d['Translation'];
        //if($tr['translator_id'] != $mt['Translator']['id']){
          $this->out(
            $post['Post']['id'] ."\t".
            preg_replace('/\s+/', ' ', $post['Post']['text']) ."\t".
            $tr['id'] ."\t". preg_replace('/\s+/', ' ', $tr['text']) ."\t".
            $tr['avg_score']
          );
        //}
      //}
    }
  }

  public function translations(){
    $data = $this->Translation->find('all', array(
      'contain' => array('Post' => array('Lang'), 'Lang'),
      'order' => 'Translation.created ASC'
    ));

    $this->dumpTranslations($data);
  }

  public function dailyTranslations(){
    $data = $this->Translation->find('all', array(
      'contain' => array('Post' => array('Lang'), 'Lang'),
      'order' => 'Translation.created ASC',
      'conditions' => array('Translation.created > NOW() - INTERVAL 24 HOUR')
    ));

    $this->dumpTranslations($data);
  }

  private function dumpTranslations($data){
    $mt = $this->Translator->findByEmail(Configure::read('MT.Translator.email'));
    foreach($data as $d){
      $tr = $d['Translation'];
      if($tr['translator_id'] != $mt['Translator']['id']){
        $this->out(
          $d['Post']['id'] ."\t".
          $d['Post']['Lang']['code'] ."\t".
          preg_replace('/\s+/', ' ', $d['Post']['text']) ."\t".
          $tr['id'] ."\t".
          $d['Lang']['code'] ."\t".
          preg_replace('/\s+/', ' ', $tr['text']) ."\t"
        );
      }
    }
  }


}

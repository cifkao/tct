<?php
App::uses('AppController', 'Controller');

class PostsController extends AppController {

  public $scaffold = 'admin';

  public $uses = array('Post', 'TranslationRequest', 'Translation', 'Lang');

  public $components = array('Paginator');

  public function index() {
    $this->Post->recursive = 2;
    $this->Post->contain(array('TwitterPost', 'Lang', 'TranslationRequest' => array('TgtLang')));
    $this->Paginator->settings = array(
      'order' => array(
        'Post.created' => 'desc'
      )
    );
    $this->set('posts', $this->Paginator->paginate());
    $this->set('langs', $this->TranslationRequest->listLangs());
  }

  public function translated($tgtLang){
    $tgtLang = $this->Lang->findByCode($tgtLang);
    $this->Paginator->settings = array(
      'contain' => array('Post'),
      'fields' => array('Translation.id', 'Post.id', 'MAX(Translation.created)'),
      'conditions' => array(
        'Translation.lang_id' => $tgtLang['Lang']['id']
      ),
      'group' => 'Post.id',
      'order' => 'MAX(Translation.created) DESC'
    );
    $postIds = array_map(function($val){
      return $val['Post']['id'];
    }, $this->Paginator->paginate('Translation'));

    $data = $this->Post->find('all', array(
      'contain' => array('TwitterPost', 'Lang', 'TranslationRequest'),
      'conditions' => array(
        'Post.id' => $postIds
      ),
      'order' => 'Post.created DESC'
    ));

    foreach($data as &$post){
      $translations = $this->Translation->find('all', array(
        'limit' => 2,
        'contain' => array('Translator', 'Lang'),
        'conditions' => array(
          'Translation.post_id' => $post['Post']['id'],
          'Translation.lang_id' => $tgtLang['Lang']['id']
        ),
        'order' => 'avg_score DESC',
        'group' => 'Translation.id'
      ));
      $post['Translation'] = array_map(function($val){
        $val['Translation']['Translator'] = $val['Translator'];
        $val['Translation']['Lang'] = $val['Lang'];
        return $val['Translation'];
      }, $translations);
    }

    $this->set('posts', $data);
    $this->set('tgtLang', $tgtLang);
    $this->set('langs', $this->TranslationRequest->listLangs());
  }

  public function view($id = null) {
    if (!$this->Post->exists($id)) {
      throw new NotFoundException(__('Invalid post'));
    }
    $options = array(
      'conditions' => array('Post.' . $this->Post->primaryKey => $id),
      'contain' => array('TwitterPost', 'Lang', 'TranslationRequest' => array('TgtLang'), 'Translation' => array('Translator', 'Lang'))
    );
    $this->Post->recursive = 2;
    $this->set('post', $this->Post->find('first', $options));
  }

}

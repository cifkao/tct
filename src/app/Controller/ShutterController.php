<?php
App::uses('AppController', 'Controller');

class ShutterController extends AppController {

  public $uses = array('Translation', 'TranslationRequest', 'TwitterTranslation', 'Scoring');

  public $components = array('Paginator');

  public function admin_index() {
    // find translation requests with at least two translations and at least two scorings
    $this->Paginator->settings = array(
      'joins' => array(
        array(
          'table' => 'translation_requests',
          'alias' => 'TranslationRequest',
          'conditions' => array(
            'Translation.translation_request_id = TranslationRequest.id',
          )
        )
      ),
      'conditions' => array('TranslationRequest.accepted_translation_id' => null),
      'fields' => array('id', 'TranslationRequest.post_id', 'TranslationRequest.tgt_lang_id', 'TranslationRequest.id'),
      'order' => array('TranslationRequest.created' => 'DESC'),
      'group' => 'TranslationRequest.id HAVING SUM(Translation.scoring_count) >= 0 AND COUNT(Translation.id) >= 2'
    );
    $reqIds = array_map(function($value){
      return $value['TranslationRequest']['id'];
    }, $this->Paginator->paginate("Translation"));
    
    // fetch the requests
    $this->TranslationRequest->resetAssociations(); // we need to do this
    $this->TranslationRequest->recursive = 2;
    $reqs = $this->TranslationRequest->find('all',
      array(
        'contain' => array('Post' => array('Lang', 'TwitterPost'), 'TgtLang'),
        'conditions' => array('TranslationRequest.id' => $reqIds),
        'order' => array('TranslationRequest.created' => 'DESC')
      )
    );
    // count scored translations, calculate best score
    foreach($reqs as &$req){
      $req['TranslationRequest']['translations'] = $this->Translation->find('count', array(
        'conditions' => array(
          'Translation.translation_request_id' => $req['TranslationRequest']['id']
        )
      ));
      $req['TranslationRequest']['translations_scored'] = $this->Translation->find('count', array(
        'conditions' => array(
          'Translation.translation_request_id' => $req['TranslationRequest']['id'],
          'Translation.scoring_count > 0'
        )
      ));

      $best = $this->Translation->find('first', array(
        'conditions' => array(
          'Translation.translation_request_id' => $req['TranslationRequest']['id']/*,
          'Translation.scoring_count > 0'*/
        ),
        'order' => 'Translation.avg_score DESC'
      ));
      $req['TranslationRequest']['best_score'] = $best['Translation']['avg_score'];
    }
    $this->set('reqs', $reqs);
  }

  public function admin_view($id = null) {
    if (!$this->TranslationRequest->exists($id)) {
      throw new NotFoundException(__('Invalid request'));
    }
    $this->TranslationRequest->recursive = 2;
    $req = $this->TranslationRequest->find('first', array(
      'conditions' => array('TranslationRequest.id' => $id),
      'contain' => array('Post' => array('Lang'), 'TgtLang')
    ));
    $translations = $this->Translation->find('all', array(
      'conditions' => array('Translation.translation_request_id' => $id),
    ));
    foreach($translations as &$tr){
      $this->Scoring->virtualFields['avg_result'] = 'AVG(result)';
      $scoring = $this->Scoring->find('first', array(
        'conditions' => array(
          'Scoring.translation_id' => $tr['Translation']['id'],
          'NOT' => array('Scoring.result' => null)
        ),
        'group' => 'Scoring.translation_id'
      ));
      if($scoring && array_key_exists('Scoring', $scoring))
        $tr['Translation']['avg_score'] = round($scoring['Scoring']['avg_result'], 1);
      else
        $tr['Translation']['avg_score'] = null;
    }

    usort($translations, function($a, $b){
      $sA = $a['Translation']['avg_score'];
      $sB = $b['Translation']['avg_score'];
      if($sA==$sB) return 0;
      return $sA<$sB ? 1 : -1;
    });

    $this->set('req', $req);
    $this->set('translations', $translations);
  }

  public function admin_publish($id){
    if($this->Translation->publish($id)){
      $this->Session->setFlash(__("Post published."));
    }else{
      $this->Session->setFlash(__("Failed to publish post."));
    }
    return $this->redirect(array('action' => 'admin_index'));
  }

  public function admin_published(){
    $this->Paginator->settings = array(
      'contain' => array('Translation' => array('Lang', 'Post' => array('Lang'), 'TwitterTranslation')),
      'order' => array('TwitterTranslation.created' => 'DESC')
    );
    $data = $this->Paginator->paginate("TwitterTranslation");

    $this->set('data', $data);
  }

}

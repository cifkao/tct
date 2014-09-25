<?php
class MaintenanceShell extends AppShell {

  public $uses = array('Translation', 'TranslationRequest', 'Scoring', 'TwitterPost', 'TwitterTranslation');

  public function updateCounters(){
    // Translation.avg_score
    $translations = $this->Translation->find('all');
    $this->Scoring->virtualFields['avg_result'] = 'AVG(result)';
    foreach($translations as $tr){
      $scoring = $this->Scoring->find('all', array(
        'conditions' => array(
          'translation_id' => $tr['Translation']['id'],
          'skipped' => false,
          'NOT' => array('result' => null)
        ),
        'group' => 'translation_id'
      ));
      $this->Translation->save(array(
        'id' => $tr['Translation']['id'],
        'avg_score' => $scoring ? $scoring[0]['Scoring']['avg_result'] : null
      ));
    }
    unset($this->Scoring->virtualFields['avg_result']);
  }

  public function updateAssociations(){
    // TranslationRequest hasMany Translation, Translation belongsTo TranslationRequest
    $translations = $this->Translation->find('all', array('fields' => array('id', 'post_id', 'lang_id')));
    foreach($translations as $tr){
      $req = $this->TranslationRequest->findByPostIdAndTgtLangId($tr['Translation']['post_id'], $tr['Translation']['lang_id']);
      if($req){
        $this->Translation->id = $tr['Translation']['id'];
        $this->Translation->saveField('translation_request_id', $req['TranslationRequest']['id']);
      }
    }
  }

  public function unpublish(){
    $data = $this->Translation->find('first', array(
      'conditions' => array('Translation.id' => $this->args[0]),
      'contain' => array('TranslationRequest', 'TwitterTranslation', 'Post' => array('TwitterPost'))
    ));

    if($data['TranslationRequest']){
      $this->TranslationRequest->id = $data['TranslationRequest']['id'];
      $this->TranslationRequest->saveField('accepted_translation_id', null);
    }

    if($data['TwitterTranslation'] && !is_null($data['TwitterTranslation']['id'])){
      $this->TwitterTranslation->delete($data['TwitterTranslation']['id']);
    }
  }

}

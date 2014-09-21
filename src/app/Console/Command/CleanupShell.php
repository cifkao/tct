<?php
class CleanupShell extends AppShell {

  public $uses = array('AuthToken', 'Scoring');

  public function main(){
    $this->AuthToken->deleteAll('AuthToken.created < NOW() - INTERVAL ' . Configure::read('AuthToken.timeout') . ' SECOND');
    $this->Scoring->deleteAll(array(
      'Scoring.result' => null,
      'Scoring.skipped' => false,
      'Scoring.created < NOW() - INTERVAL ' . Configure::read('Scoring.timeout') . ' SECOND'
    ));
  }

  public function getOptionParser() {
    $parser = parent::getOptionParser();
    return $parser;
  }

}

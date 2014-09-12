<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
  public $recursive = -1;

  public function onError() {
    $db = ConnectionManager::getDataSource('default');
    $err = $db->lastError();
    $this->log($err);
    $this->log($this->data);
  }

  /* Validation functions */

  public function sameAs($data, $cmpField){
    $val = array_values($data);
    $val = $val[0];
    
    return ($val == $this->data[$this->alias][$cmpField]);
  }

  public function notSameAs($data, $cmpField){
    return !$this->sameAs($data, $cmpField);
  }

  public function inclusiveRange($data, $lower, $upper){
    $val = array_values($data);
    $val = $val[0];
    
    return (is_numeric($val) && $lower<=$val && $val<=$upper);
  }

}

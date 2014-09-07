<?php
App::uses('AppController', 'Controller');
/**
 * TwitterTranslations Controller
 *
 * @property TwitterTranslation $TwitterTranslation
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class TwitterTranslationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->TwitterTranslation->recursive = 0;
		$this->set('twitterTranslations', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->TwitterTranslation->exists($id)) {
			throw new NotFoundException(__('Invalid twitter translation'));
		}
		$options = array('conditions' => array('TwitterTranslation.' . $this->TwitterTranslation->primaryKey => $id));
		$this->set('twitterTranslation', $this->TwitterTranslation->find('first', $options));
	}

}

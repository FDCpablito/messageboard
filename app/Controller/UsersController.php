<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $components = array('Session');
	public $name = 'Users';

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('thankyou');
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->loadModel('User'); 
				$user = $this->User->findById($this->Auth->user('id'));
				if ($user) {
					$user['User']['last_login_time'] = date('Y-m-d H:i:s');
					$this->User->save($user, false, array('last_login_time'));
				}
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash('Your username/password is incocorrect');
			}
		} 
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function index() {
		if ($this->Auth->loggedIn()) {
			$user = $this->Auth->user();
			$this->set('user', $user);
		} else {
			$this->Flash->error('You must be logged in to view this page.');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}
	

	public function thankyou() {
		
	}

	public function register() {
		if ($this->request->is('post')) {
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				// TODO: Data is valid, proceed with saving the record.
				if ($this->User->save($this->request->data)) {
					// $this->Session->setFlash('Thank you for registering');
					return $this->redirect(array('action' => 'thankyou'));
				}
			} else {
				// TODO: Data is not valid, display validation errors.
				$this->Session->setFlash('Please correct the following errors:');
			}
		}		
	}

	
}

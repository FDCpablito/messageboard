<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {
	public $components = array('Session', 'Global');
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
				// TODO: this will update the login time of user upon successful login
					if ($user) {
						$user['User']['last_login_time'] = date('Y-m-d H:i:s');
						$this->User->save($user, false, array('last_login_time'));
					}
				#end
				/**
				 * TODO: dertermin if logged in user has profile
				 * ? if Yes, then redirect to inbox
				 * ? if No, then redirect to profile add
				 */
					if ($this->Global->ifHasProfile()) {
						$this->redirect(array('controller' => 'messages', 'action' => 'inbox'));
					} else {
						$this->redirect($this->Auth->redirect());
					}
				#end
			} else {
				$this->Session->setFlash('Your username/password is incorrect');
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
		/**
		 * TODO: this will simply show the thank you page upon successful registration
		 */
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

	public function edit() {
		// TODO: Find the user data for the logged-in user
			$userId = $this->Auth->user('id');
			$user = $this->User->findById($userId);
			if (!$user) {
				throw new NotFoundException(__('Invalid user'));
			}
	
		// TODO: Process form submission
			if ($this->request->is('post') || $this->request->is('put')) {
				$this->User->id = $userId;
		
				// TODO: Validate the form data
				$this->User->set($this->request->data);
		
				if ($this->User->validates()) {
					// TODO: Save the updated user data
					if ($this->User->save($this->request->data)) {
						$this->Session->setFlash('User information updated successfully.', 'default', array('class' => 'success'));
						$this->redirect(array('controller' => 'profiles', 'action' => 'view'));
					} else {
						$this->Session->setFlash('Unable to update user information.');
					}
				} else {
						$this->Session->setFlash('Validation errors occurred. Please fix the errors and try again.');
				}
			}
		
		// TODO: Set the user data for the view
			$this->set('user', $user);
	}


}

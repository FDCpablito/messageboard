<?php
App::uses('AppController', 'Controller');
class ProfilesController extends AppController {
	public function initialize()
	{
		parent::initialize();
		
		// Load the Flash component
		$this->loadComponent('Flash');
	}


	public function index() {

	}

	public function view() {
		$data = $this->Profile->find('all', [
			'conditions' => ['user_id' => $this->Auth->user('id')],
		]);
		$this->set('data', $data);		
	}

	public function add() {
		if ($this->request->is('post')) {
			// TODO: include the current login user id
				$this->request->data['Profile']['user_id'] = $this->Auth->user('id');
				$currentDateTime = date('Y-m-d H:i:s');
			if ($this->Profile->save($this->request->data)) {
				unset($this->request->data['Profile']['user_id']);
				$this->Session->setFlash('Profile Added');
			} else {
				$this->Session->setFlash('Failed to add profile');
				$this->request->data['Profile']['user_id'] = $this->Profile->validationErrors['user_id'][0];
			}
		}
	}

	public function edit() {
		if ($this->request->is(['patch', 'post', 'put'])) {
			// TODO: Get the currently authenticated user's ID
				$userId = $this->Auth->user('id');

			// TODO: load user model and initiate save
				$newName = ($this->request->data['Profile']['name'] == null) ? $this->Auth->user('name') : $this->request->data['Profile']['name'];
				$this->loadModel('Users');
				$this->Users->id = $userId;
				$this->request->data['Profile']['user_id'] = $userId;
			
			// TODO: convert birthdate
				$birthdate = date('Y-m-d', strtotime($this->request->data['Profile']['birthdate']));
				$this->request->data['Profile']['birthdate'] = $birthdate;

			// TODO: check if user id is already in the profiles table
				$hasUserID = $this->hasUserID($userId);
			// TODO: creating profile file name
				$explode = explode('.', $this->request->data['Profile']['profile']['name']);
				$extension = explode('.', $this->request->data['Profile']['profile']['name'])[count($explode) - 1];
				$fileName = date('m-m-y') .'-'. $this->Auth->user('id') .'-'.time().'.'.$extension;
			
			if ($hasUserID == false) {
				// TODO: modify profile name
				$uploadFile = $this->uploadProfile($this->request->data['Profile']['profile'], $fileName);
				$this->request->data['Profile']['profile'] = $fileName;	
				if ($this->Profile->save($this->request->data)) {
					$this->Users->save(['name' => $newName]);
					$this->Session->setFlash('Profile Added');
				} else {
					$this->Session->error('Unable to update your profile. Please try again.');
				}
			} else {
				$uploadFile = $this->uploadProfile($this->request->data['Profile']['profile'], $fileName);
				$profile = $this->Profile->find('first', array(
					'conditions' => array('Profile.user_id' => $userId)
				));

				// TODO: modify profile name
					$this->request->data['Profile']['profile'] = $fileName;	
					$this->Profile->id = $profile['Profile']['id'];

                if ($this->Profile->save($this->request->data)) {
                    // TODO: Profile data updated successfully
						// $this->Session->setFlash('Profile updated.');
						$this->Session->setFlash('Profile update!');
						$this->Users->save(['name' => $newName]);
                } else {
                    // $this->Session->setFlash('Profile update failed.');
					$this->Session->setFlash('Profile update failed!');
                }
			}
		}
		// TODO: returns / sets the profile data of logged in user
			$profileData = $this->Profile->find('first', array(
				'conditions' => array('Profile.user_id' => $this->Auth->user('id'))
			));

			if ($profileData) {
				$this->set('profileData', $profileData);
			}
	}

	/**
	 * TODO: enable uplaod file
	 */
		private function uploadProfile($file, $fileName) {
			// TODO: Define the target directory where you want to save the uploaded files
			$uploadPath = WWW_ROOT . 'profile' . DS;
			$filename = $fileName;
			// TODO: Check if the 'profile' directory exists, create it if not
			if (!file_exists($uploadPath)) {
				mkdir($uploadPath, 0777, true);
			}

			return (move_uploaded_file($file['tmp_name'], $uploadPath . $filename)) ? true : false;
		}

	/**
	 * TODO: check if user ID is in profile
	 */
		private function hasUserID($userId) {
			$profile = $this->Profile->find('first', [
				'conditions' => ['Profile.user_id' => $userId]
			]);
			return ($profile) ? true : false;
		}
}

<?php
App::uses('AppController', 'Controller');
class ProfilesController extends AppController {
	public function initialize()
	{
		parent::initialize();
		
		// Load the Flash component
		$this->loadComponent('Flash');
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
			// TODO: validate password inputs
				if ($this->validatePassword($this->request->data['Profile']['new password'], 
					$this->request->data['Profile']['confirm password']) == false) {
					debug($this->request->data['Profile']);
					$this->Session->setFlash('Password input not match');
				}

			// TODO: Get the currently authenticated user's ID
				$userId = $this->Auth->user('id');
				$newUserName = ($this->request->data['Profile']['name'] == null) ? $this->Auth->user('name') : $this->request->data['Profile']['name'];
				$newUserEmail = ($this->request->data['Profile']['email'] == null) ? $this->Auth->user('email') : $this->request->data['Profile']['email'];
				$newUserPassword = $this->request->data['Profile']['new password'];

			// TODO: load user model and initiate save
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
					/**
					 * TODO: Update users table
					 */
						$this->updateUsersTable([
							$newUserEmail,
							$newUserPassword,
							$newUserName
						]);
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
					/**
					 * TODO: Update users table
					 */
						$this->updateUsersTable([
							$newUserEmail,
							$newUserPassword,
							$newUserName
						]);
					$this->Session->setFlash('Profile update!');
						
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
	 * TODO: this will update data in the users table
	 */
		private function updateUsersTable($data = []) {
			$this->loadModel('Users');
			$this->Users->id = $this->Auth->user('id');
			
			$email = $data[0];
			$password = ($data[1] == null) ? $user['User']['password'] : $data[1];
			$name = $data[2];

			//TODO: update the current logged in name
				$current_user['name'] = $name;
			// TODO:Update the entity fields
				return ($this->Users->save([
					'email' => $email,
					'password' => AuthComponent::password($password),
					'name' => $name,
				])) ? true : false;
		}
	

	/**
	 * TODO: validate password inputs
	 */
		public function validatePassword($newPassword, $confirmPassword) {
			return (strtolower($newPassword) == strtolower($confirmPassword)) ? true : false;
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

<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 */
class MessagesController extends AppController {

	public function inbox() {
		$messages = $this->Message->find('all', [
			'conditions' => [
				'receiver' => $this->Auth->user('id'),
			],
			'limit' => 3,
			'order' => ['Message.id' => 'DESC']
		]);
		$this->set('messages', $messages);

		// TODO: pass if has profile result
		$this->set('ifHasProfile', $this->ifHasProfile());
	} 

	public function sent() {
		$this->loadModel('User');
		$messages = $this->Message->find('all', [
			'conditions' => [
				'user_id' => $this->Auth->user('id'),
			],
			'limit' => 3,
			'order' => ['Message.id' => 'DESC']
		]);
		$this->set('messages', $messages);
		
		// TODO: pass if has profile result
		$this->set('ifHasProfile', $this->ifHasProfile());
	}

	public function add() {
		$this->loadModel('User');

		$options = $this->User->find('list', [
			'fields' => ['id', 'name'],
			'conditions' => ['User.id !=' => $this->Auth->user('id')],
		]);

		$this->set('options', $options);


		if ($this->request->is('post')) {
			$this->request->data['Message']['user_id'] = $this->Auth->user('id');
			if ($this->Message->save($this->request->data)) {
				// TODO: get the latest message id
				$latestId = $this->Message->find('all', [
					'order' => ['Message.id' => 'DESC'],
					'limit' => 1,
				])[0]['Message']['id'];
				// TODO: save to conversation table
				$this->saveToConversation(
					$latestId,
					$this->Auth->user('id'),
					$this->request->data['Message']['receiver'],
					$this->request->data['Message']['message']
				);	
				$this->Session->setFlash('Message Sent', 'default', array('class' => 'success'));
				return $this->redirect(array('action' => 'sent'));
			} else {
				$this->Session->setFlash('Failed to send message');
			}
		}		
	}

	private function saveToConversation($messageId, $senderId, $receiver_id, $message) {
		$this->loadModel('Conversation');
		$data = [
			'message_id' => $messageId,
			'sender_id' => $senderId,
			'receiver_id' => $receiver_id,
			'message' => $message
		];	
		return ($this->Conversation->save($data)) ? true : false;
}

	public function delete($id) {
		$this->autoRender = false;

		$data = $this->Message->findById($id);
		// TODO: delete message by id
			if($this->request->is('post')) {
				$this->Message->id = $id;
				if ($this->Message->delete($this->request->data)) {
					echo json_encode([
						'status' => 'success',
						'message' => 'Data deleted successfully'
					]);
				}
			}
	}

	/**
	 * TODO: fetch sent box based on number of given items
	 * ? this is accessed using ajax
	 */
		public function fetchSentBox($userId, $limit) {
			$this->autoRender = false;
		
			$limit = ($limit == null || $limit <= 0) ? 10 : $limit;
		
			$conditions = [];
			if ($userId !== null) {
				$conditions['user_id'] = $userId;
			}
		
			$messages = $this->Message->find('all', [
				'conditions' => $conditions,
				'limit' => $limit,
				'order' => [
					'Message.id' => 'DESC'
				]
			]);

			echo json_encode($messages);
		}
		
	/**
	 * TODO: fetch inbox based on nubmer given
	 * ? this is accessed using ajax
	 */

		public function fetchInbox($userId, $limit) {
			$this->autoRender = false;
		
			$limit = ($limit == null || $limit <= 0) ? 10 : $limit;
		
			$conditions = [];
			if ($userId !== null) {
				$conditions['receiver'] = $userId;
			}
		
			$messages = $this->Message->find('all', [
				'conditions' => $conditions,
				'limit' => $limit,
				'order' => [
					'Message.id' => 'DESC'
				]
			]);

			echo json_encode($messages);
		}

		
	/**
	 * TODO: this will determine if user has profile
	 * ? If not the user will be redirected to add / update profiles page
	 * ? IF Yes, proceed accordingly
	 */
		private function ifHasProfile() {
			$userId = $this->Auth->user('id');

			$this->loadModel('Profile');

			$profile = $this->Profile->findById($userId);

			return ($profile) ? true : false;
		}
}

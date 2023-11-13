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
			'order' => ['Message.id' => 'DESC']
		]);
		$this->set('messages', $messages);
	} 

	public function sent() {
		$this->loadModel('User');

		$messages = $this->Message->find('all', [
			'conditions' => [
				'user_id' => $this->Auth->user('id'),
			],
			'order' => ['Message.id' => 'DESC']
		]);
		$this->set('messages', $messages);
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
				$this->Session->setFlash('Message Sent');
				return $this->redirect(array('action' => 'sent'));
			} else {
				$this->Session->setFlash('Failed to send message');
			}
		}		
	}

	// TODO: save to conversation table
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
}

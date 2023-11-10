<?php
App::uses('AppController', 'Controller');
/**
 * Conversations Controller
 */
class ConversationsController extends AppController {
	
	protected $receiverId;
	protected $messageId;
	public function view($id) {
		// TODO: fetch all conversations
			$conversations = $this->Conversation->find('all', [
				'conditions' => [
					'message_id' => $id
				],
				'order' => ['Conversation.id' => 'DESC']
			]);	
		// TODO: get the values
			foreach ($conversations as $key => $value) {
				$this->receiverId = $value['Conversation']['receiver_id'];
				$this->messageId = $value['Conversation']['message_id'];
			}
			
		$this->set('conversations', $conversations);
		$this->set('messageId', $this->messageId);
		$this->set('receiverId', $this->receiverId);
	}

	public function add() {
		if ($this->request->is('ajax')) {
			$this->autoRender = false;
			// TODO: validate data
			$this->Conversation->create(); // Ensure you create a new record
			$conversationData = [
				'message_id' => $this->request->data['messageId'],
				'sender_id' => $this->Auth->user('id'),
				'receiver_id' => $this->request->data['receiverId'],
				'message' => $this->request->data['Conversation']['message']
			];
			if ($this->Conversation->save($conversationData)) {
				echo json_encode([
					'status' => 'success',
					'message' => 'Data submitted successfully'
				]);
			} else {
				echo json_encode([
					'status' => 'failed',
					'message' => 'Failed to save message'
				]);
			}
		} else {
			echo json_encode([
				'status' => 'failed', 
				'message' => 'Failed to send message'
			]);
		}
	}

	public function fetch($messageId = null) {
		$this->autoRender = false;
	
		$conditions = [];
		if ($messageId !== null) {
			$conditions['message_id'] = $messageId;
		}
	
		$conversations = $this->Conversation->find('all', [
			'conditions' => $conditions,
			'limit' => 10,
			'order' => ['Conversation.id' => 'DESC']
		]);
	
		echo json_encode($conversations);
	}
	
}

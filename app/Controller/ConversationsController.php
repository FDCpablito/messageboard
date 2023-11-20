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
			$this->Conversation->create();
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

	public function fetch($messageId = null, $numberConvo, $message) {
		$this->autoRender = false;
		
		$numberConvo = ($numberConvo == null) ? 10: $numberConvo;

		$conditions = [];
		// TODO: fetch conversations with the same message ID
			if ($messageId !== null) {
				$conditions['message_id'] = $messageId;
			}
		// TODO: fetch the conversations which messages are like the $message
			 if ($message !== 'no search') {
				$conditions['OR'] = [
					'Conversation.message LIKE' => '%' . $message . '%' // Include conversations with messages like the specified message
				];
			}
		$conversations = $this->Conversation->find('all', [
			'conditions' => $conditions,
			'limit' => $numberConvo,
			'order' => ['Conversation.id' => 'DESC']
		]);
	
		echo json_encode($conversations);
	}

	/**
	 * TODO: check if there newly inserted data in the conversations
	 */
		public function checkUpdates() {
			$this->autoRender = false;
	
			// TODO: check for updates in the database
			$hasUpdates = $this->Conversation->checkForUpdates();
	
			echo json_encode([
				'hasUpdates' => $hasUpdates,
				'time' => date('Y-m-d H:i:s', strtotime('-60 seconds'))
			]);
		}

	/**
	 * TODO: search Conversations
	 */
		public function searchConversations($message) {
			$this->autoRender = false;

		}
}

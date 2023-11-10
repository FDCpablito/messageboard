<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'isUnique' => array (
				'rule' => array('isUnique'),
				'message' => 'Email is already taken.'
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Only email are required',
				'required' => true,
			),
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'password cannot be empty',
			),
			'Match Passwords' => array(
				'rule' => 'matchPassword',
				'message' => 'Passwords do not match'
			)
		),
		'password_confirm' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'confirm password cannot be empty',
			), 
			
		),
		'name' => array(
			'isBetween' => array(
				'rule' => array('between',  5, 20),
				'message' => 'The name must be 5 to 20 characters'
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'name cannot be empty',
			),
		),
	);

	
	public function matchPassword($data) {
		if($data['password'] == $this->data['User']['password_confirm']) {
			return true;
		}
		$this->invalidate('password_confirm', 'Passwords do not match.');
		return false;
	}
	
	public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
           $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
}

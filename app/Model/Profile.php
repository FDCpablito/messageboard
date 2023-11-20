<?php
App::uses('AppModel', 'Model');
/**
 * Profile Model
 *
 * @property User $User
 */
class Profile extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'profile';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'is Unique' => array(
				'rule' => array('numeric'),
				'message' => 'You\'ve already added your profile'
			)
		),
		'profile' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
			'validateExtension' => array(
				'rule' => array('extension', ['jpeg', 'jpg', 'png', 'gif']),
				'message' => 'The file must be a JPEG, JPG, PNG or GIF'
			)
		),
		'gender' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'birthdate' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'Date required',
				//'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'hubby' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Hubby is required'
			),
		)
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}

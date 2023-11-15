<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	/**
	 * * These routers are for the conversations controller
	 * ? they're accessed using ajax
	 * ? they handle the interaction to the database using ajax
	 */
		// TODO: fetch new messages in the conversation
		Router::connect('/messageboard/Conversations/fetch/*', array('controller' => 'conversations', 'action' => 'fetch'));
		// TODO: check for updates in the conversations table / model
		Router::connect('/messageboard/Conversation/checkForUpdates', array(
			'controller' => 'conversations', 'actions' => 'checkUpdates'
		));

	/**
	 * * These routers are for the messages controller
	 * ? they're accessed using ajax
	 * ? they handle the interaction to the database using ajax
	 */
		// TODO: delete messages and converstations under the message
		Router::connect('/messageboard/Messages/delete/*', array('controller' => 'messages', 'action' => 'delete'));
		// TODO: fetch sent box
		Router::connect('/messageboard/Messages/fetchSentBox/*', array('controller' => 'messages', 'action', 'fetchSentBox'));
		// TODO: fetch inbox
		Router::connect('/messageboard/Messages/fetchInbox/*', array('controller' => 'messages', 'action', 'fetchInbox'));

		/**
		 * 
		 */

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

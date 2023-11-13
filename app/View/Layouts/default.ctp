<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Message Board
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>

	<?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'); ?>

	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!-- jQuery -->
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->

	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
	<!-- Select2 JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>
<style>
	.ui-datepicker {
        background-color: #fff;
    }

</style>
<body>
	<div id="container">
		<!-- <div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'https://cakephp.org'); ?></h1>
		</div> -->
		<div id="content">

			<!-- <div>
				<?php if($logged_in) :?>
					Welcome <?php echo $current_user['name']; ?>
					<?php echo $this->HTML->link('Edit Profile', array('controller' =>'profiles', 'action' => 'edit')); ?>
					<?php echo $this->HTML->link('View Profile', array('controller' =>'profiles', 'action' => 'view')); ?>

					<?php echo $this->HTML->link('Logout', array('controller' =>'users', 'action' => 'logout')); ?>
				<?php else :?>
					<?php echo $this->HTML->link('Login', array('controller' =>'users', 'action' => 'login'));?>
        			<?php	echo $this->HTML->link('Register', array('controller' => 'users', 'action' => 'register'));  ?>
				<?php endif; ?>
			</div> -->

			<!-- In your CakePHP view file or layout -->
			<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-4 p-1">
				<a class="navbar-brand" href="#">Message Board</a>
				
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ml-auto">
					<?php if ($logged_in) : ?>
						<li class="nav-item">
							<span class="nav-link"><?php echo 'Welcome | ' . $current_user['name']; ?></span>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Messages
							</a>
							<div class="dropdown-menu" aria-labelledby="messagesDropdown">
								<?php echo $this->Html->link('Inbox', array('controller' => 'messages', 'action' => 'inbox'), array('class' => 'dropdown-item')); ?>
								<?php echo $this->Html->link('Sent Box', array('controller' => 'messages', 'action' => 'sent'), array('class' => 'dropdown-item')); ?>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="profilesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Profiles
							</a>
							<div class="dropdown-menu" aria-labelledby="profilesDropdown">
								<?php echo $this->Html->link('Edit Profile', array('controller' => 'profiles', 'action' => 'edit'), array('class' => 'dropdown-item')); ?>
								<?php echo $this->Html->link('View Profile', array('controller' => 'profiles', 'action' => 'view'), array('class' => 'dropdown-item')); ?>
							</div>
						</li>
						<li class="nav-item">
							<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'), array('class' => 'nav-link')); ?>
						</li>
					<?php else : ?>
						<li class="nav-item">
							<?php echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'), array('class' => 'nav-link')); ?>
						</li>
						<li class="nav-item">
							<?php echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'register'), array('class' => 'nav-link')); ?>
						</li>
					<?php endif; ?>

					</ul>
				</div>

				
			</nav>


			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<!-- <div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'https://cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div> -->
	</div>
</body>
</html>

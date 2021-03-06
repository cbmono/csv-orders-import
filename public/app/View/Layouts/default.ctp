<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>


<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>

	<title>
		Basic fulfillment tool: 
		<?php echo $title_for_layout; ?>
	</title>

	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css');
		echo $this->Html->css('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css');
		echo $this->Html->css('//cdn.datatables.net/1.9.4/css/jquery.dataTables.css');
		echo $this->Html->css('style');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>

<body>
  
	<div id="container" class="container-fluid">
		<div class="row">
			<header>
				<h1>Basic fulfillment tool</h1>
			</header>
			
			<div id="content">

				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
			</div>

			<footer></footer>
		</div>
	</div>

	<?php echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js'); ?>
	<?php echo $this->Html->script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js'); ?>
	<?php echo $this->Html->script('//cdn.datatables.net/1.9.4/js/jquery.dataTables.min.js'); ?>
	<?php echo $this->Html->script('app'); ?>
</body>
</html>
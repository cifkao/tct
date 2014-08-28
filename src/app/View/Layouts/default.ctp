<?php

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon')."\n";
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0'));

		echo $this->Html->css('foundation')."\n";
		echo $this->Html->css('foundation-icons')."\n";
		echo $this->Html->css('tct')."\n";
		
		echo $this->Html->script("vendor/modernizr")."\n";
		
		echo $this->fetch('meta')."\n";
		echo $this->fetch('css')."\n";
		echo $this->fetch('script')."\n";
	?>
</head>
<?php
		if (isset($bodyId)) {
				$bodyId = "$bodyId";
		} else {
				$bodyId = null;
		}
?>
<body id=<?php echo $bodyId; ?>>
	<div class="row">
		<div class="large-12 columns">
			
			<div class="icon-bar six-up" id="nav-bar">
				<?php echo $this->Html->link( '<img src="img/logo.svg" id="nav-home"/>', '/', array( 'class' => 'item', 'id' => 'logo', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
				<?php echo $this->Html->link( '<i class="fi-list-bullet" id="nav-phrases"></i><label for="nav-phrases">Tweets</label>', array( 'controller' => 'posts', 'action' => 'index' ), array( 'class' => 'item', 'id' => 'nav-bar-phrases', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
				<?php echo $this->Html->link( '<i class="fi-heart" id="nav-score"></i><label for="nav-phrases">Score</label>', array( 'controller' => 'scoring', 'action' => 'index' ), array( 'class' => 'item', 'id' => 'nav-bar-score', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
				<?php echo $this->Html->link( '<i class="fi-torsos-all" id="nav-translators"></i><label for="nav-translators">Translators</label>', array( 'controller' => 'translators', 'action' => 'index' ), array( 'class' => 'item', 'id' => 'nav-bar-translators', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
				<?php echo $this->Html->link( '<i class="fi-info" id="nav-about"></i><label for="nav-about">About</label>', '/about', array( 'class' => 'item', 'id' => 'nav-bar-about', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
				<?php echo $this->Html->link( '<i class="fi-social-twitter" id="nav-twitter"></i><label for="nav-twitter">@tctranslation</label>', 'http://twitter.com/tctranslation', array( 'target' => '_blanc', 'class' => 'item', 'id' => 'nav-bar-twitter', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<?php echo $this->Session->flash('flash', array( 'element' => 'tctFlash' ) ); ?>
		
		<?php echo $this->fetch('content'); ?>
	</div>
	
	<footer class="row">
		<div class="large-12 columns">
			<hr/>
			<div class="large-2 columns">
				<?php echo $this->Html->link( '<i class="fi-social-twitter"></i>&nbsp;<span>@tctranlation</span>', 'http://twitter.com/tctranslation', array( 'target' => '_blanc', 'class' => 'item', 'id' => 'nav-bar-twitter', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
			</div>
			<div class="large-2 columns">
				<?php echo $this->Html->link(
						$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
						'http://www.cakephp.org/',
						array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
					);
				?>
				<br/>
				<a href="http://foundation.zurb.com" target="_blanc" class="round label">foundation 5 | power</a>
			</div>
			<div class="large-5 columns">
			</div>
			<div class="large-3 columns text-right">
				<p>© Copyright Reserved</p>
			</div>
		</div>
	</footer>

	
	<?php
	echo $this->Html->script("foundation.min")."\n";
	echo $this->Html->script("vendor/jquery")."\n";
	echo $this->Html->script("foundation/foundation")."\n";
	echo $this->Html->script("foundation/foundation.alert")."\n";
	echo $this->Html->script("foundation/foundation.tooltip")."\n";
	echo $this->Html->script("foundation/foundation.joyride")."\n";
	echo $this->Html->script("vendor/jquery.cookie")."\n";
	?>
	<script>
		$(document).foundation();
		$(document).foundation().foundation('alert', 'event');
	</script>
</body>
</html>

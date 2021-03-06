<?php

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php /*echo $cakeDescription*/ ?>TCT:
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
			
			<!-- navigation for mobile -->
			<div class="hide-for-large-up">
				<nav class="top-bar" data-topbar role="navigation">
					<ul class="title-area">
						<li class="name">
							<h1>
								<?php echo $this->Html->link(__('tct'),
								array('controller' => 'pages', 'action' => 'home'), array( 'tabindex' => '0', 'escape' => false ) ); ?>
							</h1>
						</li>
						<li class="toggle-topbar menu-icon"><a href="#"><span><?php echo __('Menu');?></span></a></li>
					</ul>
					<section class="top-bar-section">
						<ul class="left">
							<li>
								<?php echo $this->Html->link( '<i class="fi-list-bullet"></i>&nbsp;Tweets', array( 'controller' => 'posts', 'action' => 'index' ), array( 'id' => 'nav-bar-phrases', 'tabindex' => '0', 'escape' => false ) ); ?>
							</li>
							<li>
								<?php echo $this->Html->link( '<i class="fi-heart"></i>&nbsp;Score', array( 'controller' => 'scoring', 'action' => 'index' ), array( 'id' => 'nav-bar-score', 'tabindex' => '0', 'escape' => false ) ); ?>
							</li>
							<li>
								<?php echo $this->Html->link( '<i class="fi-torsos-all"></i>&nbsp;Translators', array( 'controller' => 'translators', 'action' => 'index' ), array( 'id' => 'nav-bar-translators', 'tabindex' => '0', 'escape' => false ) ); ?>
							</li>
							<li>
								<?php echo $this->Html->link( '<i class="fi-info"></i>&nbsp;About', '/about', array('id' => 'nav-bar-about', 'tabindex' => '0', 'escape' => false ) ); ?>
							</li>
							<li>
								<?php echo $this->Html->link( '<i class="fi-social-twitter"></i>&nbsp;@tctranslation', 'http://twitter.com/tctranslation', array( 'target' => '_blank', 'id' => 'nav-bar-twitter', 'tabindex' => '0', 'escape' => false ) ); ?>
							</li>
						</ul>
					</section>
				</nav>
			</div>
			
			<!-- navigation for desktop -->
			<div class="show-for-large-up">
				<div class="icon-bar six-up" id="nav-bar">
					<?php echo $this->Html->link($this->Html->image('logo.svg', array('id' => 'nav-home', 'alt' => __('TCT'))),
					array('controller' => 'pages', 'action' => 'home'), array( 'class' => 'item', 'id' => 'logo', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
					<?php echo $this->Html->link( '<i class="fi-list-bullet" id="nav-phrases"></i><label for="nav-phrases">Tweets</label>', array( 'controller' => 'posts', 'action' => 'index' ), array( 'class' => 'item', 'id' => 'nav-bar-phrases', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
					<?php echo $this->Html->link( '<i class="fi-heart" id="nav-score"></i><label for="nav-phrases">Score</label>', array( 'controller' => 'scoring', 'action' => 'index' ), array( 'class' => 'item', 'id' => 'nav-bar-score', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
					<?php echo $this->Html->link( '<i class="fi-torsos-all" id="nav-translators"></i><label for="nav-translators">Translators</label>', array( 'controller' => 'translators', 'action' => 'index' ), array( 'class' => 'item', 'id' => 'nav-bar-translators', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
					<?php echo $this->Html->link( '<i class="fi-info" id="nav-about"></i><label for="nav-about">About</label>', '/about', array( 'class' => 'item', 'id' => 'nav-bar-about', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
					<?php echo $this->Html->link( '<i class="fi-social-twitter" id="nav-twitter"></i><label for="nav-twitter">@tctranslation</label>', 'http://twitter.com/tctranslation', array( 'target' => '_blank', 'class' => 'item', 'id' => 'nav-bar-twitter', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
				</div>
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
				<?php echo $this->Html->link( '<i class="fi-social-twitter"></i>&nbsp;<span>@tctranslation</span>', 'http://twitter.com/tctranslation', array( 'target' => '_blank', 'class' => 'item', 'id' => 'nav-bar-twitter', 'role' => 'button', 'tabindex' => '0', 'escape' => false ) ); ?>
			</div>
			<div class="large-7 columns">
				powered by: 
				<?php echo $this->Html->link( 'CakePHP 2.5.3', 'http://www.cakephp.org/', array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')); ?>,&nbsp;
				<?php echo $this->Html->link( 'Zurb Foundation 5', 'http://www.foundation.zurb.com/', array('target' => '_blank', 'escape' => false)); ?>&nbsp;and&nbsp;
				<?php echo $this->Html->link( 'Moses Decoder', 'http://www.statmt.org/moses/', array('target' => '_blank', 'escape' => false)); ?>
			</div>
			<div class="large-3 columns text-right">
				<p>© Charles University in Prague, <a href="http://ufal.mff.cuni.cz/" target="_blank">ÚFAL</a></p>
			</div>
		</div>
	</footer>

	
	<?php
  echo $this->Html->script("vendor/jquery")."\n";
  echo $this->Html->script("foundation.min")."\n";
  echo $this->Html->script("foundation/foundation")."\n";
  echo $this->Html->script("foundation/foundation.alert")."\n";
  echo $this->Html->script("foundation/foundation.tooltip")."\n";
  echo $this->Html->script("foundation/foundation.joyride")."\n";
	echo $this->Html->script("foundation/foundation.topbar")."\n";
	echo $this->Html->script("foundation/foundation.dropdown")."\n";
  echo $this->Html->script("vendor/jquery.cookie")."\n";
  echo $this->Html->script("vendor/jquery.autosize")."\n";
  echo $this->Html->script("submit-translations")."\n";
  echo $this->fetch('script')."\n";
  echo $this->Js->writeBuffer();
	?>
	<script>
		$(document).foundation();
		$(document).foundation().foundation('alert', 'event');
	</script>
	<?php /*echo $this->element('sql_dump');*/ ?>
</body>
</html>

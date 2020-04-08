<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var string $username
 */

$this->extend("layout/columns");
?>

<?php $this->beginBlock("title"); ?>
Psr framework - cabinet
<?php $this->endBlock(); ?>

<?php $this->beginBlock("navbar"); ?>
<a href="<?=$this->generatePath("home")?>">Home</a>
<a href="<?=$this->generatePath("blog")?>">Blog</a>
<a href="<?=$this->generatePath("about")?>">About</a>
<a class="active" href="<?=$this->generatePath("cabinet")?>">Cabinet</a>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("breadcrumb"); ?>
<ul>
	<li><a href="<?=$this->generatePath("home")?>">Home</a></li>
	<li>Cabinet</li>
</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("main"); ?>
<div class="content">
	<h3>Cabinet of <?=$this->encode($username);?></h3>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("sidebar"); ?>
<div class="side">
	<div>
		<h3>Cabinet</h3>
		<ul>
			<li>Profile</li>
			<li>Settings</li>
			<li>Log out</li>
		</ul>
	</div>
</div>
<?php $this->endBlock(); ?>
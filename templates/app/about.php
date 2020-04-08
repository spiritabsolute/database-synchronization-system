<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 */

$this->extend("layout/columns");
?>

<?php $this->beginBlock("title"); ?>
	Psr framework - about
<?php $this->endBlock(); ?>

<?php $this->beginBlock("meta"); ?>
<meta name="description" content="About page description">
<?php $this->endBlock(); ?>

<?php $this->beginBlock("navbar"); ?>
<a href="<?=$this->generatePath("home")?>">Home</a>
<a href="<?=$this->generatePath("blog")?>">Blog</a>
<a class="active" href="<?=$this->generatePath("about")?>">About</a>
<a href="<?=$this->generatePath("cabinet")?>">Cabinet</a>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("breadcrumb"); ?>
<ul>
	<li><a href="<?=$this->generatePath("home")?>">Home</a></li>
	<li>About</li>
</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("main"); ?>
<div class="content">
	<h3>Why do we use it?</h3>
	<p>
		It is a long established fact that a reader will be distracted by the readable content of a page when
		looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution
		of letters, as opposed to using 'Content here, content here', making it look like readable English. Many
		desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a
		search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved
		over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
	</p>
</div>
<?php $this->endBlock(); ?>
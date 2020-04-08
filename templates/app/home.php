<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 */

$this->extend("layout/default");
?>

<?php $this->beginBlock("title"); ?>
Psr framework - home
<?php $this->endBlock(); ?>

<?php $this->beginBlock("meta"); ?>
<meta name="description" content="Home page description">
<meta name="author" content="spiritabsolute">
<?php $this->endBlock(); ?>

<?php $this->beginBlock("navbar"); ?>
<a class="active" href="<?=$this->generatePath("home")?>">Home</a>
<a href="<?=$this->generatePath("blog")?>">Blog</a>
<a href="<?=$this->generatePath("about")?>">About</a>
<a href="<?=$this->generatePath("cabinet")?>">Cabinet</a>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("content"); ?>
<div class="content">
	<h3>What is Lorem Ipsum?</h3>
	<p>
		Lorem Ipsum is simply dummy text of the printing and typesetting industry.
		Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
		printer took a galley of type and scrambled it to make a type specimen book. It has survived
		not only five centuries, but also the leap into electronic typesetting, remaining essentially
		unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
		passages, and more recently with desktop publishing software like Aldus PageMaker including versions of
		Lorem Ipsum.
	</p>
</div>
<?php $this->endBlock(); ?>
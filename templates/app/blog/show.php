<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var \App\ReadModel\Views\PostView $post
 */

$this->extend("layout/default");
?>

<?php $this->beginBlock("title"); ?>
Psr framework - <?= $this->encode($post->title); ?>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("meta"); ?>
<meta name="description" content="<?= $this->encode($post->title); ?>">
<?php $this->endBlock(); ?>

<?php $this->beginBlock("navbar"); ?>
<a href="<?=$this->generatePath("home")?>">Home</a>
<a class="active" href="<?=$this->generatePath("blog")?>">Blog</a>
<a href="<?=$this->generatePath("about")?>">About</a>
<a href="<?=$this->generatePath("cabinet")?>">Cabinet</a>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("breadcrumb"); ?>
<ul>
	<li><a href="<?=$this->generatePath("home")?>">Home</a></li>
	<li><a href="<?=$this->generatePath("blog")?>">Blog</a></li>
	<li><?= $this->encode($post->title); ?></li>
</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("content"); ?>
<div class="content">
	<h3><?= $this->encode($post->title); ?></h3>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?= $post->date->format("Y-m-d"); ?>
		</div>
		<div class="panel-body">
			<?=nl2br($this->encode($post->content))?>
		</div>
	</div>
</div>
<?php $this->endBlock(); ?>
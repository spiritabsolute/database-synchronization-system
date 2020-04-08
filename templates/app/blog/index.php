<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var \App\ReadModel\PostReadRepository $posts
 */

$this->extend("layout/default");
?>

<?php $this->beginBlock("title"); ?>
Psr framework - blog
<?php $this->endBlock(); ?>

<?php $this->beginBlock("meta"); ?>
<meta name="description" content="Blog page description">
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
	<li>Blog</li>
</ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock("content"); ?>
<div class="content">
	<h3>Blog</h3>
	<?php foreach ($posts as $post): ?>
		<article>
			<h4>
				<a href="<?= $this->encode($this->generatePath("blog_show", ["id" => $post->id])); ?>">
					<?= $this->encode($post->title); ?>
				</a>
			</h4>
			<span><?= $post->date->format("Y-m-d"); ?></span>
			<p><?=nl2br($this->encode($post->content))?></p>
		</article>
	<?php endforeach; ?>
</div>
<?php $this->endBlock(); ?>
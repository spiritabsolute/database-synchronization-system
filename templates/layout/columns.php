<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var string $content
 */

$this->extend("layout/default");
?>

<?php $this->beginBlock("content"); ?>

<?= $this->renderBlock("main"); ?>

<?php if ($this->ensureBlock("sidebar")): ?>
<div class="side">
	<div>
		<h3>Navigation</h3>
		<ul>
			<li>Link 1</li>
			<li>Link 2</li>
			<li>Link 3</li>
		</ul>
	</div>
</div>
<?php $this->endBlock(); endif; ?>
<?= $this->renderBlock("sidebar"); ?>

<?php $this->endBlock(); ?>
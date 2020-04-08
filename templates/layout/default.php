<?php
/**
* @var \Framework\Template\Php\PhpRenderer $this
* @var string $content
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?= $this->renderBlock("title"); ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= $this->renderBlock("meta"); ?>
	<link href="/css/default.css" rel="stylesheet">
</head>
<body>
<header>
	<div class="brand">
		<h3>Psr</h3>
	</div>
	<nav class="nav-links">
		<?= $this->renderBlock("navbar"); ?>
	</nav>
</header>
<section>
	<nav class="breadcrumb">
		<?= $this->renderBlock("breadcrumb"); ?>
	</nav>
</section>
<main>
	<?= $this->renderBlock("content"); ?>
</main>
<footer>
	<p class="copyright">&copy; 2018</p>
</footer>
</body>
</html>
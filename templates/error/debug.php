<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 * @var \Throwable $exception
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Error</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= $this->renderBlock("meta"); ?>
	<link href="/css/error.css" rel="stylesheet">
</head>
<body>

<main>
	<h1>Exception: <?=$this->encode($exception->getMessage())?></h1>

	<p>Code: <?=$this->encode($exception->getCode())?></p>
	<p><?=$this->encode($exception->getFile())?> on line <?=$this->encode($exception->getLine())?></p>
	<?php foreach ($exception->getTrace() as $trace): ?>
		<p><?=$this->encode($trace["file"])?> on line <?=$this->encode($trace["line"])?></p>
	<?php endforeach; ?>
</main>

</body>
</html>
<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 */

$this->extend("layout/default");
?>

<?php $this->beginBlock("title"); ?>
Psr framework - 500 (Server error)
<?php $this->endBlock(); ?>

<?php $this->beginBlock("content"); ?>
	<h3>500 - Server error</h3>
<?php $this->endBlock(); ?>
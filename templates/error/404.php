<?php
/**
 * @var \Framework\Template\Php\PhpRenderer $this
 */

$this->extend("layout/default");
?>

<?php $this->beginBlock("title"); ?>
Psr framework - 404 (Not found)
<?php $this->endBlock(); ?>

<?php $this->beginBlock("content"); ?>
<h3>404 - Not found</h3>
<?php $this->endBlock(); ?>

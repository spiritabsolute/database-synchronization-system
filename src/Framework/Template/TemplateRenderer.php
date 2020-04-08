<?php
namespace Framework\Template;

interface TemplateRenderer
{
	public function render($view, $params = []): string;
}
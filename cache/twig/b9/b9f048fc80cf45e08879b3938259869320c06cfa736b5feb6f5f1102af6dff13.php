<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* layout/default.html.twig */
class __TwigTemplate_831e07b2e7eac547fdf5f1ff0268d78a830f9609ec67ee90fb12476340a199c9 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'meta' => [$this, 'block_meta'],
            'navbar' => [$this, 'block_navbar'],
            'breadcrumb' => [$this, 'block_breadcrumb'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
\t<title>";
        // line 4
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
\t<meta charset=\"utf-8\">
\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
\t";
        // line 7
        $this->displayBlock('meta', $context, $blocks);
        // line 8
        echo "\t<link href=\"/css/default.css\" rel=\"stylesheet\">
</head>
<body>
<header>
\t<div class=\"brand\">
\t\t<h3>Psr</h3>
\t</div>
\t<nav class=\"nav-links\">
\t\t";
        // line 16
        $this->displayBlock('navbar', $context, $blocks);
        // line 17
        echo "\t</nav>
</header>
<section>
\t<nav class=\"breadcrumb\">
\t\t";
        // line 21
        $this->displayBlock('breadcrumb', $context, $blocks);
        // line 22
        echo "\t</nav>
</section>
<main>
\t";
        // line 25
        $this->displayBlock('content', $context, $blocks);
        // line 26
        echo "</main>
<footer>
\t<p class=\"copyright\">&copy; 2018</p>
</footer>
</body>
</html>";
    }

    // line 4
    public function block_title($context, array $blocks = [])
    {
    }

    // line 7
    public function block_meta($context, array $blocks = [])
    {
    }

    // line 16
    public function block_navbar($context, array $blocks = [])
    {
    }

    // line 21
    public function block_breadcrumb($context, array $blocks = [])
    {
    }

    // line 25
    public function block_content($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "layout/default.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  109 => 25,  104 => 21,  99 => 16,  94 => 7,  89 => 4,  80 => 26,  78 => 25,  73 => 22,  71 => 21,  65 => 17,  63 => 16,  53 => 8,  51 => 7,  45 => 4,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout/default.html.twig", "/home/spiritabsolute/TestTasks/SystemTechnology/templates/twig/layout/default.html.twig");
    }
}

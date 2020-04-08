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

/* layout/columns.html.twig */
class __TwigTemplate_41199918f6a1a03fc998be7ba4b182c6c6c8ca6607c15b0e049a34df54f32257 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
            'main' => [$this, 'block_main'],
            'sidebar' => [$this, 'block_sidebar'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout/default.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("layout/default.html.twig", "layout/columns.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        // line 4
        echo "\t";
        $this->displayBlock('main', $context, $blocks);
        // line 5
        echo "\t";
        $this->displayBlock('sidebar', $context, $blocks);
    }

    // line 4
    public function block_main($context, array $blocks = [])
    {
    }

    // line 5
    public function block_sidebar($context, array $blocks = [])
    {
        // line 6
        echo "\t\t<div class=\"side\">
\t\t\t<div>
\t\t\t\t<h3>Navigation</h3>
\t\t\t\t<ul>
\t\t\t\t\t<li>Link 1</li>
\t\t\t\t\t<li>Link 2</li>
\t\t\t\t\t<li>Link 3</li>
\t\t\t\t</ul>
\t\t\t</div>
\t\t</div>
\t";
    }

    public function getTemplateName()
    {
        return "layout/columns.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  65 => 6,  62 => 5,  57 => 4,  52 => 5,  49 => 4,  46 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "layout/columns.html.twig", "/home/spiritabsolute/TestTasks/SystemTechnology/templates/twig/layout/columns.html.twig");
    }
}

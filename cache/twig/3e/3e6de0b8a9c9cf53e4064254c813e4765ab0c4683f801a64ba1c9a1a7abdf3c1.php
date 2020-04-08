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

/* app/about.html.twig */
class __TwigTemplate_6497c6313d13aaf4024817c53a38199d68cca6579aaa97a0b816bf96025fdcc6 extends \Twig\Template
{
    private $source;

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'meta' => [$this, 'block_meta'],
            'navbar' => [$this, 'block_navbar'],
            'breadcrumb' => [$this, 'block_breadcrumb'],
            'main' => [$this, 'block_main'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout/columns.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("layout/columns.html.twig", "app/about.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo "Psr framework - about";
    }

    // line 5
    public function block_meta($context, array $blocks = [])
    {
        // line 6
        echo "\t<meta name=\"description\" content=\"About page description\">
";
    }

    // line 9
    public function block_navbar($context, array $blocks = [])
    {
        // line 10
        echo "\t<a href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("home"), "html", null, true);
        echo "\">Home</a>
\t<a href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("blog"), "html", null, true);
        echo "\">Blog</a>
\t<a class=\"active\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("about"), "html", null, true);
        echo "\">About</a>
\t<a href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("cabinet"), "html", null, true);
        echo "\">Cabinet</a>
";
    }

    // line 16
    public function block_breadcrumb($context, array $blocks = [])
    {
        // line 17
        echo "\t<ul>
\t\t<li><a href=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("home"), "html", null, true);
        echo "\">Home</a></li>
\t\t<li>About</li>
\t</ul>
";
    }

    // line 23
    public function block_main($context, array $blocks = [])
    {
        // line 24
        echo "\t<div class=\"content\">
\t\t<h3>Why do we use it?</h3>
\t\t<p>
\t\t\tIt is a long established fact that a reader will be distracted by the readable content of a page when
\t\t\tlooking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution
\t\t\tof letters, as opposed to using 'Content here, content here', making it look like readable English. Many
\t\t\tdesktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a
\t\t\tsearch for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved
\t\t\tover the years, sometimes by accident, sometimes on purpose (injected humour and the like).
\t\t</p>
\t</div>
";
    }

    public function getTemplateName()
    {
        return "app/about.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  101 => 24,  98 => 23,  90 => 18,  87 => 17,  84 => 16,  78 => 13,  74 => 12,  70 => 11,  65 => 10,  62 => 9,  57 => 6,  54 => 5,  48 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "app/about.html.twig", "/home/spiritabsolute/TestTasks/SystemTechnology/templates/twig/app/about.html.twig");
    }
}

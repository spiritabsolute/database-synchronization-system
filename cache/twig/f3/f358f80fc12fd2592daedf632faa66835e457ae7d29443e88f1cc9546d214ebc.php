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

/* app/home.html.twig */
class __TwigTemplate_3aab6370ccf6f10589476de652aead1ce25f361acfbd5e5c2efcc4a65e5077dd extends \Twig\Template
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
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "layout/default.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $this->parent = $this->loadTemplate("layout/default.html.twig", "app/home.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo "Psr framework - home";
    }

    // line 5
    public function block_meta($context, array $blocks = [])
    {
        // line 6
        echo "\t<meta name=\"description\" content=\"Home page description\">
\t<meta name=\"author\" content=\"spiritabsolute\">
";
    }

    // line 10
    public function block_navbar($context, array $blocks = [])
    {
        // line 11
        echo "\t<a class=\"active\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("home"), "html", null, true);
        echo "\">Home</a>
\t<a href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("blog"), "html", null, true);
        echo "\">Blog</a>
\t<a href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("about"), "html", null, true);
        echo "\">About</a>
\t<a href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("cabinet"), "html", null, true);
        echo "\">Cabinet</a>
";
    }

    // line 17
    public function block_content($context, array $blocks = [])
    {
        // line 18
        echo "\t<div class=\"content\">
\t\t<h3>What is Lorem Ipsum?</h3>
\t\t<p>
\t\t\tLorem Ipsum is simply dummy text of the printing and typesetting industry.
\t\t\tLorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
\t\t\tprinter took a galley of type and scrambled it to make a type specimen book. It has survived
\t\t\tnot only five centuries, but also the leap into electronic typesetting, remaining essentially
\t\t\tunchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum
\t\t\tpassages, and more recently with desktop publishing software like Aldus PageMaker including versions of
\t\t\tLorem Ipsum.
\t\t</p>
\t</div>
";
    }

    public function getTemplateName()
    {
        return "app/home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  87 => 18,  84 => 17,  78 => 14,  74 => 13,  70 => 12,  65 => 11,  62 => 10,  56 => 6,  53 => 5,  47 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "app/home.html.twig", "/home/spiritabsolute/TestTasks/SystemTechnology/templates/twig/app/home.html.twig");
    }
}

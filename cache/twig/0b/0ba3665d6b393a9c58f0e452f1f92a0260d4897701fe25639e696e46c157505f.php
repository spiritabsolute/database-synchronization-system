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

/* app/blog/index.html.twig */
class __TwigTemplate_6515118034cb27058b88931843bd27c6be38d0b6cc9ef610abf76f0b6e769cc6 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("layout/default.html.twig", "app/blog/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        echo "Psr framework - blog";
    }

    // line 5
    public function block_meta($context, array $blocks = [])
    {
        // line 6
        echo "\t<meta name=\"description\" content=\"Blog page description\">
";
    }

    // line 9
    public function block_navbar($context, array $blocks = [])
    {
        // line 10
        echo "\t<a href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("home"), "html", null, true);
        echo "\">Home</a>
\t<a class=\"active\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("blog"), "html", null, true);
        echo "\">Blog</a>
\t<a href=\"";
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
\t\t<li>Blog</li>
\t</ul>
";
    }

    // line 23
    public function block_content($context, array $blocks = [])
    {
        // line 24
        echo "\t<div class=\"content\">
\t\t<h3>Blog</h3>
\t\t";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["posts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
            // line 27
            echo "\t\t\t<article>
\t\t\t\t<h4><a href=\"";
            // line 28
            echo twig_escape_filter($this->env, $this->extensions['Framework\Template\Twig\Extension\Route']->generatePath("blog_show", ["id" => twig_get_attribute($this->env, $this->source, $context["post"], "id", [])]), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "title", []), "html", null, true);
            echo "</a></h4>
\t\t\t\t<span>";
            // line 29
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "date", []), "d.m.Y"), "html", null, true);
            echo "</span>
\t\t\t\t<p>";
            // line 30
            echo nl2br(twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["post"], "content", []), "html", null, true));
            echo "</p>
\t\t\t</article>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "\t</div>
";
    }

    public function getTemplateName()
    {
        return "app/blog/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 33,  122 => 30,  118 => 29,  112 => 28,  109 => 27,  105 => 26,  101 => 24,  98 => 23,  90 => 18,  87 => 17,  84 => 16,  78 => 13,  74 => 12,  70 => 11,  65 => 10,  62 => 9,  57 => 6,  54 => 5,  48 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "app/blog/index.html.twig", "/home/spiritabsolute/TestTasks/SystemTechnology/templates/twig/app/blog/index.html.twig");
    }
}

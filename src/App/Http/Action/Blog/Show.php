<?php
namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class Show
{
	/**
	 * @var PostReadRepository
	 */
	private $posts;
	/**
	 * @var TemplateRenderer
	 */
	private $template;

	public function __construct(PostReadRepository $posts, TemplateRenderer $template)
	{
		$this->posts = $posts;
		$this->template = $template;
	}

	public function __invoke(ServerRequestInterface $request, callable $next)
	{
		if (!$post = $this->posts->find($request->getAttribute("id")))
		{
			return $next($request);
		}

		return new HtmlResponse($this->template->render("app/blog/show", [
			"post" => $post
		]));
	}
}
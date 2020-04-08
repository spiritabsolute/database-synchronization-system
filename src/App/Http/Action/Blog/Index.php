<?php
namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;

class Index
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

	public function __invoke()
	{
		$posts = $this->posts->getAll();

		return new HtmlResponse($this->template->render("app/blog/index", [
			"posts" => $posts
		]));
	}
}
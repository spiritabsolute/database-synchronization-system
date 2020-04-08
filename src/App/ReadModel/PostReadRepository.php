<?php
namespace App\ReadModel;

use App\ReadModel\Views\PostView;

class PostReadRepository
{
	private $posts = [];

	public function __construct()
	{
		$this->posts = [
			new PostView(1, new \DateTimeImmutable(), "The first post", "The first post content"),
			new PostView(2, new \DateTimeImmutable(), "The second post", "The second post content")
		];
	}

	/**
	 * @return PostView[]
	 */
	public function getAll(): array
	{
		return array_reverse($this->posts);
	}

	public function find($id): ?PostView
	{
		foreach ($this->posts as $post)
		{
			if ($post->id === (int)$id)
			{
				return $post;
			}
		}
		return null;
	}
}
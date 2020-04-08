<?php
namespace App\ReadModel\Views;

class PostView
{
	public $id;
	/**
	 * @var \DateTimeImmutable
	 */
	public $date;
	public $title;
	public $content;

	public function __construct($id, \DateTimeImmutable $date, $title, $content)
	{
		$this->id = $id;
		$this->date = $date;
		$this->title = $title;
		$this->content = $content;
	}
}
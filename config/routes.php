<?php
use App\Http\Action;

/**
 * @var \Framework\Http\Application $app
 */

$app->get("home", "/", Action\Home::class);
$app->get("about", "/about", Action\About::class);
$app->get("cabinet", "/cabinet", [
	$container->get(App\Http\Middleware\BasicAuth::class),
	Action\Cabinet::class
]);
$app->get("blog", "/blog", Action\Blog\Index::class);
$app->get("blog_show", "/blog/{id}", Action\Blog\Show::class, ["tokens" => ["id" => "\d+"]]);
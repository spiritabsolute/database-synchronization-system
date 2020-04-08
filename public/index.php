<?php
use Framework\Http\Application;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * @var \Psr\Container\ContainerInterface $container
 * @var \Framework\Http\Application $app
 */

require __DIR__."/../vendor/autoload.php";

$container = require __DIR__."/../config/container.php";

$app = $container->get(Application::class);
require __DIR__."/../config/routes.php";
require __DIR__."/../config/pipeline.php";

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
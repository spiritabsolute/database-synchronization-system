<?php
use App\Http\Middleware;
use Framework\Http\Middleware\Dispatch;
use Framework\Http\Middleware\Route;

/**
 * @var \Framework\Http\Application $app
 */

$app->pipe(\Framework\Http\Middleware\ErrorHandler\ErrorHandler::class);
$app->pipe(Middleware\Credentials::class);
$app->pipe(Middleware\Profiler::class);
$app->pipe(Route::class);
$app->pipe(Dispatch::class);
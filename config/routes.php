<?php
use App\Http\Action;

/**
 * @var \Framework\Http\Application $app
 */

$app->get("home", "/", Action\Home::class);
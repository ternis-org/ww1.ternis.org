<?php

declare(strict_types=1);

/**
 * Root entry point for ternis.org
 */

define('ROOT_PATH', __DIR__);
define('PUBLIC_PATH', __DIR__ . '/public');

require ROOT_PATH . '/bootstrap.php';

/** @var Router $router */
$router->dispatch();

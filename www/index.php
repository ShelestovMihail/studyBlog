<?php
require __DIR__ . '/autoload.php';

use \LiamProject\View\View;

try {
	$route = $_GET['route'] ?? '';
	$routes = require __DIR__ . '/../src/routes.php';

	$isRouteFound = false;
	foreach ($routes as $pattern => $controllerAndAction) {
	    preg_match($pattern, $route, $matches);
	    if (!empty($matches)) {
	        $isRouteFound = true;
	        break;
	    }
	}

	if (!$isRouteFound) {
	    $view = new View(__DIR__ . '/../templates/');
	    throw new \LiamProject\Exceptions\NotFoundException();
	}

	unset($matches[0]);

	$controllerName = $controllerAndAction[0];
	$actionName = $controllerAndAction[1];

	$controller = new $controllerName();
	$controller->$actionName(...$matches);
} catch (\LiamProject\Exceptions\DbException $e) {
	$view = new View('../templates/');
	$view->renderhtml('errors/500.php', ['error' => $e->getMessage()], 500);
} catch (\LiamProject\Exceptions\NotFoundException $e) {
	$view = new View('../templates/');
	$view->renderHtml('errors/404.php', ['error' => $e->getMessage()], 404);
}
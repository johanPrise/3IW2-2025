<?php

// Charger les routes
$routes = yaml_parse_file(__DIR__ . '/routes.yml');

// Récupérer l'URL demandée
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Chercher la route
$found = false;
foreach ($routes as $path => $config) {
    if ($path === $uri) {
        $found = true;

        // Charger le contrôleur
        require_once __DIR__ . '/Controllers/' . $config['controller'] . '.php';

        $controllerClass = 'Controllers\\' . $config['controller'];
        $controller = new $controllerClass();
        $action = $config['action'];

        // Appeler l'action
        $controller->$action();
        break;
    }
}

// Si pas trouvé -> 404
if (!$found) {
    http_response_code(404);
    echo "<h1>404 - Page non trouvée</h1>";
}


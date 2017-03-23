<?php

//$router = $di->getRouter();

// Define your routes here

use Phalcon\Mvc\Router as Router;

$router = new Phalcon\Mvc\Router(false); 

$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);

$router->notFound(
    [
        "controller" => "error",
        "action"     => "show404",
    ]
);


// $router->add(
//     "/",
//     [
//         "controller" => "login",
//         "action"     => "index",
//     ]
// );

return $router;

//$router->handle();

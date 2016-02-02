<?php

require __DIR__.'/vendor/autoload.php';

use Elasticsearchexample\Application;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'world',
            'user'      => 'root',
            'password' => '',
            'charset' => 'utf8',
    ),
));

$elasticSearchTest = new Application();
$app->get('/myApp/run', function() use( $app, $elasticSearchTest) {
    $sql = "SELECT * FROM city ";
    $users = $app['db']->fetchAll($sql);
    $response = $elasticSearchTest->run($users);
    return new \Symfony\Component\HttpFoundation\JsonResponse($response->getData());
});

$app->run();



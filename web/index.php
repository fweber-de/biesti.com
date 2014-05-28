<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('root');

$app->get('/portfolio', function () use ($app) {
    return $app['twig']->render('portfolio.html.twig');
});

$app->get('/contact', function () use ($app) {
    return $app['twig']->render('contact.html.twig');
});

$app->get('/imprint', function () use ($app) {
    return $app['twig']->render('imprint.html.twig');
});

$app['debug'] = false;

$app->run();

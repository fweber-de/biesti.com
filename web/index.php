<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/portfolio', function () use ($app) {
    return $app['twig']->render('portfolio.html.twig');
});

$app->get('/kontakt', function () use ($app) {
    return $app['twig']->render('kontakt.html.twig');
});

$app->get('/impressum', function () use ($app) {
    return $app['twig']->render('impressum.html.twig');
});

$app['debug'] = true;

$app->run();

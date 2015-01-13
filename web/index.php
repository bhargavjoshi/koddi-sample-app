<?php

use Silex\Application;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//Load Composer AutoLoad File
require_once __DIR__.'/../vendor/autoload.php';

// Create a new instance of an silex application
$app = new Silex\Application();

// Register PropelOrm with the application
$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.config_file' => __DIR__.'/../config/propel/config.php'
));

// Register Twig with application
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../app/views',
));

// Register UrlGenerator with application
$app->register(new UrlGeneratorServiceProvider());

//Register SessionServiceProvider with application
$app->register(new Silex\Provider\SessionServiceProvider());

//Register ServiceController with application
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

//Turn on the app debugging
$app['debug'] = true;

//Register UserService Provider
$app->register(new \Koddi\User\UserServiceProvider());

//Register PostService provider
$app->register(new \Koddi\Post\PostServiceProvider());

//Define AuthController
$app['auth.controller'] = $app->share(function() use ($app) {
    return new \Koddi\Controller\AuthController();
});

//Define PostController
$app['post.controller'] = $app->share(function() use ($app) {
    return new \Koddi\Controller\PostController();
});

//Before Filter for authentication
$authBeforeFilter = function (Request $request, Application $app) {
    if (null === $user = $app['session']->get('user')) {
        return $app->redirect('/login');
    }
};

$app->get('/', function () use ($app) {
    return $app['twig']->render('home.twig');
})->before($authBeforeFilter);

$app->get('/login', 'auth.controller:getLogin');

$app->get('/register', 'auth.controller:getRegister');
$app->post('/register', 'auth.controller:postRegister')->bind('post-register');

$app->post('/post-status', 'post.controller:postStatus')->bind('post-status')->before($authBeforeFilter);

$app->get('/all-posts', 'post.controller:getAllPosts')->bind('all-posts')->before($authBeforeFilter);

$app->run();

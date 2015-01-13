<?php

namespace Koddi\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    public function getLogin(Application $app)
    {
        $username = $app['request']->server->get('PHP_AUTH_USER', false);
        $password = $app['request']->server->get('PHP_AUTH_PW');

        $user = $app['userService']->checkCredentials($username, $password);

        if ($user) {
            $app['session']->set('user', $user);
            return $app->redirect('/');
        }

        $response = new Response();
        $response->headers->set('WWW-Authenticate', sprintf('Basic realm="%s"', 'site_login'));
        $response->setStatusCode(401, 'Please sign in.');
        return $response;
    }

    public function getRegister(Application $app)
    {
        return $app['twig']->render('register.twig');
    }

    public function postRegister(Application $app)
    {
        $username = $app['request']->request->get('username');
        $password = $app['request']->request->get('password');

        // Create a new user

        $app['userService']->addUser($username, $password);

        //Add response
        $response = new Response();
        $response->setStatusCode(200, 'UserAdded');
        return $response;
    }
}
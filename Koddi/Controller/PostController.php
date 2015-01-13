<?php

namespace Koddi\Controller;


use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class PostController
{
    public function postStatus(Application $app)
    {
        $post = $app['request']->request->get('post');

        if ($post == '' || strlen($post) > 140) {
            return new Response('Message length should be of 140 characters only.', 403);
        }

        $user = $app['session']->get('user');

        $app['postService']->addPost($user, $post);

        return $app->redirect('/all-posts');
    }

    public function getAllPosts(Application $app)
    {
        $user = $app['session']->get('user');
        $posts = $app['postService']->getAllPostByUser($user);

        return $app['twig']->render('list.twig', array('posts' => $posts));
    }

}
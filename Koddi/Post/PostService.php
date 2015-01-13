<?php

namespace Koddi\Post;

use Koddi\User\User;

class PostService
{
    public function addPost(User $user, $message)
    {
        $post = new Post();
        $post
            ->setPost($message)
            ->setUser($user);

        $post->save();
    }

    public function getAllPostByUser(User $user)
    {
        $posts = PostQuery::create()
            ->filterByUser($user)
            ->find();

        return $posts;
    }

}
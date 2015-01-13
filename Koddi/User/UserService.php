<?php
namespace Koddi\User;

class UserService
{
    /**
     * @param $username
     * @param $password
     */
    public function addUser($username, $password)
    {
        $user = new User();
        $user
            ->setUsername($username)
            ->setPassword($password);

        $user->save();
    }

    /**
     * Check Login Credentials
     * @param $username
     * @param $password
     * @return User[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function checkCredentials($username, $password)
    {
        $user = UserQuery::create()
            ->filterByUsername($username)
            ->filterByPassword($password)
            ->findOne();

        return $user;
    }
}

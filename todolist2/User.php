<?php

namespace TODOLIST\todolist1;

class User
{
    protected $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function signIn()
    {
        $usersJson = file_get_contents('User.json');
        $users = json_decode($usersJson, true);
        foreach ($users as $user) {
            if ($user['userName'] == $this->username) {
                return 'Đã có người dùng';
            }
        }
        $users[] = ['userName' => $this->username, 'password' => $this->password];
        file_put_contents('User.json', json_encode($users));
        return 'Đăng ký thành công';
    }
    public function login()
    {
        $usersJson = file_get_contents('User.json');
        $users = json_decode($usersJson, true);

        foreach ($users as $user) {
            if ($user['userName'] == $this->username && $user['password'] == $this->password) {
                return  $this->getUsername();
            }
        }
        return false;
    }
}

<?php
require_once "Connect_DB.php";
session_start();
class Authorization
{
    private $user;

    function __construct()
    {
        $this->user = new User();
    }

    function authentication($user)
    {
        $userDao = new UsersDao();
        $userData = $userDao->getAll();
        foreach ($userData as $usData){
            if ($usData["login"] == $user->getLogin()){
                if ($usData["password"] == md5($user->getPassword())){
                    $name = $usData["name"];
                    setcookie("login", $usData["login"]);
                    $_SESSION["login"] = $user->getLogin();
                    exit(json_encode(array("result"=>"true", "user"=>$name)));
                }
            }
        }
    }


}
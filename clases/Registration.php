<?php
require_once "Connect_DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/scripts/function.php";
require_once $_SERVER['DOCUMENT_ROOT']."/clases/ValidateUser.php";

class Registration
{
    private $user;

    function __construct(){
        $this->user = new User();
    }

    function appendUser($user){
        $valid = new ValidateUser();
        $userDao = new UsersDao();
            if ($valid->checkLoginDb($user->getLogin()) && $valid->checkEmailDb($user->getEmail())){
                $userDao->insert($user);
            }
    }

}
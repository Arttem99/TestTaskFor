<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/UsersDao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/scripts/function.php";
session_start();

if (isset($_POST["method"])){
    if ($_POST["method"] == "data_transfer_for_Registration")
    {
        data_transfer_for_Registration();
    }
    if ($_POST["method"] == "update")
    {
        update();
    }
    if ($_POST["method"] == "authorization")
    {
        authorization();
    }
    if ($_POST["method"] == "exit")
    {
        exits();
    }
    if ($_POST["method"] == "delete")
    {
        deleteUser();
    }
    if ($_POST["method"] == "viewInfo")
    {
        viewInfo();
    }
    if ($_POST["method"] == "getInfo")
    {
        getDataUser();
    }
}

function data_transfer_for_Registration(){
    $user = new User();
    $user->setLogin($_POST["login"]);
    $user->setPassword($_POST["password"]);
    $user->setEmail($_POST["email"]);
    $user->setName($_POST["name"]);
    appendUser($user);
}

function update(){
    $user = new User();
    $user->setLogin($_POST["new_login"]);
    $user->setPassword($_POST["new_password"]);
    $user->setEmail($_POST["new_email"]);
    $user->setName($_POST["new_name"]);
    $userDao = new UsersDao();
    $userDao->update($user);
}

function getUserInfo(){
$userDao = new UsersDao();
 echo $userDao->getAll();
}

function authorization(){
    $user = new User();
    $user->setLogin($_POST["login"]);
    $user->setPassword($_POST["password"]);
    authentication($user);
}

function exits(){
    unset($_SESSION['name']);
    unset($_SESSION['login']);
    session_destroy();
    echo $_SESSION["name"];
}

function deleteUser(){
    if (isset($_POST["login"])){
        $userDao = new UsersDao();
        $userDao->delete($_POST["login"]);
    }
    outputDataUser();
}

function viewInfo(){
    outputDataUser();
}

function getDataUser(){
    $userDao = new UsersDao();
    $userInf = $userDao->getUserByLogin($_POST["login"]);
    exit(json_encode(array('login'=>strval($userInf->login), "pass"=>strval($userInf->password), "email"=>strval($userInf->email), "name"=>strval($userInf->name))));

}

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/clases/Registration.php";
require_once $_SERVER['DOCUMENT_ROOT']."/clases/Authorization.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/UsersDao.php";
session_start();
function generation_exception($string, $field){
    exit(json_encode(array('result' => 'false', 'string'=> $string, 'field'=>$field)));
}

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
}



function data_transfer_for_Registration(){
    $user = new User();
    $user->setLogin($_POST["login"]);
    $user->setPassword($_POST["password"]);
    $user->setEmail($_POST["email"]);
    $user->setName($_POST["name"]);
    $Adduser = new Registration();
    $Adduser->appendUser($user);

}

function update(){
    $user = new User();
    $user->setLogin($_POST["login"]);
    $user->setPassword($_POST["password"]);
    $user->setEmail($_POST["email"]);
    $user->setName($_POST["name"]);
    $das = new UsersDao();
    $das->update($user);

}

function authorization(){
    $user = new User();
    $user->setLogin($_POST["login"]);
    $user->setPassword($_POST["password"]);
    $authUser = new Authorization();
    $authUser->authentication($user);
}

function exits(){
    $_SESSION["login"] ="";
}

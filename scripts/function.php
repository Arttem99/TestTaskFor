<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/Connect_DB.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/clases/User.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/clases/UsersDao.php";

function generation_exception($string, $field){
    exit(json_encode(array('result' => 'false', 'string'=> $string, 'field'=>$field)));
}

function outputDataUser(){
$userData = new UsersDao();
$users = $userData->getAll();
$output = '
<table>
    <tr>
        <th>Login</th>
        <th>Password</th>
        <th>Email</th>
        <th>Name</th>
    </tr>
    <div>';
        foreach ($users as $user) {
            $output .= '         
            <tr>
                <td>' . strval($user["login"]) . '</td>
                <td>' . strval($user["password"]) . '</td>
                <td>' . strval($user["email"]) . '</td>
                <td>' . strval($user["name"]) . '</td>
                <td><button class="btn_edit_user" value=' . strval($user["login"]) . '>Edit</button></td>
                <td><button class="btn_delete_user" value=' . strval($user["login"]) . '>Delete</button></td>
            </tr>';
        }
$output .='
             </div>
            </table>';
        echo $output;
}

function authentication($user)
{
    $userDao = new UsersDao();
    $userData = $userDao->getAll();
    foreach ($userData as $usData){
        if (strval($usData["login"]) == $user->getLogin()){
            if (strval($usData["password"]) == ($userDao->salt . md5(trim($user->getPassword())))){
                setcookie("login", strval($usData["login"]));
                $_SESSION["login"] = strval($usData["login"]);
                $_SESSION["name"] = strval($usData["name"]);
                exit(json_encode(array("result"=>"true", "user"=>strval($usData["name"]))));
            }

        }


    }
}

function appendUser($user){
    $userDao = new UsersDao();
    if ($userDao->checkLoginDb($user->getLogin()) && $userDao->checkEmailDb($user->getEmail())){
        $userDao->insert($user);
        authentication($user);
    }
}



<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/Connect_DB.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/clases/User.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/clases/CRUD.php";

$connection = new Connect_DB();

function generation_exception($string, $field)
{
    exit(json_encode(array('result' => 'false', 'string' => $string, 'field' => $field)));
}

function outputDataUser()
{
    global $connection;
    $crud = new CRUD($connection);
    $users = $crud->read();
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
    $output .= '
             </div>
            </table>';
    echo $output;
}

function authentication($user)
{
    global $connection;
    $crud = new CRUD($connection);
    $userData = $crud->read();
    foreach ($userData as $usData) {
        if (strval($usData["login"]) == $user->getLogin()) {
            if (strval($usData["password"]) == ($crud->salt . md5(trim($user->getPassword())))) {
                setcookie("login", strval($usData["login"]));
                setcookie("name", strval($usData["name"]));
                $_SESSION["login"] = strval($usData["login"]);
                $_SESSION["name"] = strval($usData["name"]);
                exit(json_encode(array("result" => "true", "user" => strval($usData["name"]))));
            }
//
        }
    }
    return generation_exception("Проверьте введенные данные!", "login");
}

function registration($user)
{
    global $connection;
    $crud = new CRUD($connection);
    if (checkLoginDb($user->getLogin()) && checkEmailDb($user->getEmail()) && checkPasswordValid($user->getPassword())
        && checkEmailValid($user->getEmail()) && checkNameValid($user->getName())) {
        $crud->create($user);
        authentication($user);
    }
}

function checkLoginDb($login)
{
    global $connection;
    $users = $connection;
    $users = $users->xml;
    if (checkLoginValid($login)) {
        foreach ($users->user as $user) {
            if ($user->login == $login) {
                generation_exception("Такой логин уже существует!!!", "login");
                return false;
            }
        }
    }
    return true;
}

function checkEmailDb($email)
{
    global $connection;
    $users = $connection;
    $users = $users->xml;
    if (checkEmailValid($email)) {
        foreach ($users->user as $user) {
            if ($user->email == $email) {
                generation_exception("Такой email уже существует!!!", "email");
                return false;
            }
        }
    }
    return true;
}

function checkPasswordValid($password)
{
    if (!preg_match("#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$#", $password)) {
        generation_exception("Пароль должен состоять минимум из 6 символов, обязательно должны содержать цифру, буквы в разных регистрах и спец символ (знаки)!!!", "password");
        return false;
    } else {
        return true;
    }
}

function checkEmailValid($email)
{
    if (!preg_match("#^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$#", $email)) {
        generation_exception("Проверьте Email на корректность", "email");
        return false;
    } else {
        return true;
    }
}

function checkLoginValid($login)
{
    if (!preg_match("#^[а-яА-ЯёЁa-zA-Z0-9]+$#", $login)) {
        generation_exception("Проверьте логин на корректность! Логин должен сожержать только буквы и цифры", "login");
        return false;
    } else {
        return true;
    }
}

function checkNameValid($name)
{
    if (!preg_match("#^[а-яА-ЯёЁa-zA-Z0-9]{2,}$#", $name)) {
        generation_exception("Имя должено содежать минимум 2 символа из букв и цифр!", "login");
        return false;
    } else {
        return true;
    }
}

function getUserByLogin($login)
{
    global $connection;
    $users = $connection;
    $users = $users->xml;
    foreach ($users->user as $user) {
        if ($user->login == $login) {
            return $user;
        }
    }
}

function data_transfer_for_Registration()
{
    $user = new User();
    $user->setLogin($_POST["login"]);
    $user->setPassword($_POST["password"]);
    $user->setEmail($_POST["email"]);
    $user->setName($_POST["name"]);
    registration($user);
}

function update()
{
    global $connection;
    $user = new User();
    $user->setLogin($_POST["new_login"]);
    $user->setPassword($_POST["new_password"]);
    $user->setEmail($_POST["new_email"]);
    $user->setName($_POST["new_name"]);
    $crud = new CRUD($connection);
    if (checkLoginDb($user->getLogin()) && checkEmailDb($user->getEmail()) && checkPasswordValid($user->getPassword())
        && checkEmailValid($user->getEmail()) && checkNameValid($user->getName())) {
        $crud->update($_POST["old_login"], $user);
    }
    outputDataUser();
}

function getUserInfo()
{
    global $connection;
    $crud = new CRUD($connection);
    echo $crud->read();
}

function authorization()
{
    $user = new User();
    $user->setLogin($_POST["login"]);
    $user->setPassword($_POST["password"]);
    authentication($user);
}

function exits()
{
    unset($_SESSION['name']);
    unset($_SESSION['login']);
    unset($_COOKIE['login']);
    unset($_COOKIE['name']);
    session_destroy();
    echo $_SESSION["name"];

}

function deleteUser()
{
    global $connection;
    if (isset($_POST["login"])) {
        $crud = new CRUD($connection);
        $crud->delete(array(getUserByLogin($_POST["login"])));
    }
    outputDataUser();
}

function viewInfo()
{
    outputDataUser();
}

function getDataUser()
{
    $userInf = getUserByLogin($_POST["login"]);
    exit(json_encode(array('login' => strval($userInf->login), "password" => strval($userInf->password), "email" => strval($userInf->email), "name" => strval($userInf->name))));
}

<?
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/Connect_DB.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/clases/UsersDao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/scripts/action.php";
session_start();

?>
<html>
<head>
    <title></title>
    <meta>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</head>
<body>
<div class="data-user">
    <h2 class="user"><?php if ($_SESSION['name'] != "") echo "Hello " . $_SESSION['name']; ?></h2> <input type="button"
                                                                                                          value="Exit"
                                                                                                          id="btn-exit">
    <input type="button" value="Admin" id="btn-admin">
</div>
<div class="authorization div_field">
    <form>
        <div class="block_auth"><span>Login: </span> <input class="for-clear" type="text" placeholder="Login"
                                                            id="login-auth"></div>
        <div class="block_auth"><span>Password: </span> <input class="for-clear" type="password" placeholder="Password"
                                                               id="password-auth"></div>
        <input type="button" id="btn_log_in" value="Log In">
    </form>

</div>
<div class="block_check div_field"><input type="checkbox" id="isRegistration" value="false"
                                          placeholder="Авторизоваться"><span>Зарегистрироваться</span></div>
<div class="registration div_field">
    <form>
        <div class="block_login"><span>Login: </span> <input class="for-clear" type="text" placeholder="Login"
                                                             id="login"><span id="err_login" class="error"></span></div>
        <div class="block_pass"><span>Password: </span> <input class="for-clear" type="password" placeholder="Password"
                                                               id="password"><span id="err_pass" class="error"></span>
        </div>
        <div class="block_conf_pass"><span>Confirm password: </span> <input class="for-clear" type="password"
                                                                            placeholder="Password" id="comf_pass"><span
                    id="err_confpass" class="error"></span></div>
        <div class="block_email"><span>Email: </span> <input class="for-clear" type="email" placeholder="Email"
                                                             id="email"><span id="err_email" class="error"></span></div>
        <div class="block_name"><span>Your Name: </span> <input class="for-clear" type="text" placeholder="Name"
                                                                id="name_user"><span id="err_user" class="error"></span>
        </div>
        <input type="button" id="btn_sign_up" value="Sign up">
    </form>
</div>
<span class="error" id="error"></span>

</body>

<script src="js/script.js?<? echo mt_rand(); ?>"></script>
</html>


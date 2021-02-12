var login;
var password;
var name;
var email;

document.addEventListener("DOMContentLoaded", isUser);

function StringMoreSymbols(string, length) {
        if (string.length < length){
            return false;
        }
        else {
            return true;
        }
}
login = $('#login').val();
$('#login').change(function () {
   if (!StringMoreSymbols($('#login').val(), 6)){
       $('#err_login').fadeIn().html('Логин должен состоять минимум из 6 символов!');
       setTimeout(function () {
       $('#err_login').fadeOut("Slow");
       }, 4000);
    }
   else {
       login = $('#login').val();
   }
});

password = $('#password').val();
$('#password').change(function () {
    if (StringMoreSymbols($('#password').val(), 6)){
       if (isPassword($('#password').val()))
       {
           password = $('#password').val();
       }
       else {
           $('#err_pass').fadeIn().html('Пароль должен состоять минимум из 6 символов, обязательно должны содержать цифру, буквы в разных регистрах и спец символ (знаки)!');
           setTimeout(function () {
               $('#err_pass').fadeOut("Slow");
           }, 4000);
       }
    }
});

function isPassword(password){
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
    if (!regex.test(password)) {
        return false;
    } else {
        return true;
    }
}

$('#comf_pass').change(function () {
    if (!IsMatchingPasswords()){
        $('#err_confpass').fadeIn().html('Пароли не совпадают!');
        setTimeout(function () {
            $('#err_confpass').fadeOut("Slow");
        }, 4000);
    }
});

function IsMatchingPasswords() {
    if (StringMoreSymbols($('#password').val(), 6) && StringMoreSymbols($('#comf_pass').val(), 6))
    if ($('#comf_pass').val() != $('#password').val()){
        return false;
    }
    else {
        return true;
    }
}

name = $('#name_user').val();
$('#name_user').change(function () {
    if (!StringMoreSymbols($('#name_user').val(), 2 )){
        $('#err_user').fadeIn().html('Имя должено содежать минимум 2 символа!');
        setTimeout(function () {
            $('#err_user').fadeOut("Slow");
        }, 4000);
    }
    else
    {
        name = $('#name_user').val();
    }
});

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

email = $('#email').val();
$('#email').change(function () {
    if ($('#email').val() == ""){
        $('#err_email').fadeIn().html('Заполните поле!');
        setTimeout(function () {
            $('#err_email').fadeOut("Slow");
        }, 4000);
    }
    else {
        if(IsEmail($('#email').val()) == false){
            $('#err_email').fadeIn().html('Введите емайл верно!');
            setTimeout(function () {
                $('#err_email').fadeOut("Slow");
            }, 4000);
        }
        else {
            email = $('#email').val();
        }
    }
});
$(".registration").hide();


$("#isRegistration").click(function () {
    $(".registration").hide();
    $(".authorization").show();
    $("#isRegistration").not(this).each(function () {
        this.checked = false;
    });
    if (this.checked){
        $(".registration").show();
        $(".authorization").hide();
    }
});


$('#btn_sign_up').click(function (e) {
    e.preventDefault();
        if (StringMoreSymbols(login, 6) && StringMoreSymbols(name, 2) &&
            IsMatchingPasswords() && IsEmail(email)) {
            $.ajax({
                url: "../scripts/action.php",
                type: "Post",
               dataType: "json",
                data: {
                    method: "data_transfer_for_Registration",
                    login: login,
                    password: password,
                    email: email,
                    name: name
                },
                success: function (data) {
                    if (data.result == "false") {
                        definitionField(data.field, data.string);
                    } else {
                        $(".registration").hide();
                        $('#error').fadeIn().html(data.string);
                        $(".user").html("Hello " +data.user);
                        $(".data-user").show();
                        isUser();
                        viewDataUser();
                        clearField();
                    }
                }
            });
        }
        else
        {
            $('#error').fadeIn().html('Заполните все поля!!!');
            setTimeout(function () {
                $('#error').fadeOut("Slow");
            }, 4000);
        }
});

function definitionField(field, string) {
    if (field == "login"){
        $('#err_login').fadeIn().html(string);
        setTimeout(function () {
            $('#err_login').fadeOut("Slow");
        }, 4000);
    }
    else if (field == "email") {
        $('#err_email').fadeIn().html(string);
        setTimeout(function () {
            $('#err_email').fadeOut("Slow");
        }, 4000);
    }
}


$("#btn_log_in").click(function (e) {
    e.preventDefault();
    if ($(".block_auth #login-auth").val().length != 0 && $(".block_auth #password-auth").val().length !=0){
        $.ajax({
           url:"../scripts/action.php",
            type:"Post",
            dataType: "json",
            data:{
               method: "authorization",
                login: $("#login-auth").val(),
                password: $("#password-auth").val()
            },
            success: function (data) {
                if (data.result == "true"){
                    $(".user").html("Hello " +data.user);
                    $(".data-user").show();
                    $(".div_field").hide();
                    clearField();
                }
            }

        });

    }
    else {
        $('#error').fadeIn().html('Заполните все поля!!!');
        setTimeout(function () {
            $('#error').fadeOut("Slow");
        }, 4000);
    }

});
$("#btn-exit").click(function (e) {
   e.preventDefault();
   $.ajax({
       url: "../scripts/action.php",
       type:"Post",
       data:{
           method:"exit"
       },
       success:function (data) {
           $(".user").html(data);
           isUser();
       }
   });
});

function isUser(){
    $("#btn_update").hide();
   if ($(".user").html()!=""){
       $(".div_field").hide();
       // $("#isRegistration").hide();
   }
   else {
       $(".data-user").hide();
       $(".authorization").show();
       $(".block_check").show();
   }
}



var valLogin ;
$("button.btn_delete_user").click(function (event) {
    var button = event.target;
    valLogin = button.value;
});

$("button.btn_edit_user").click(function (event) {
    var button = event.target;
    valLogin = button.value;
});

function viewDataUser(){
    $.ajax({
        url: "../scripts/action.php",
        type: "POST",
        data:{
            method: "viewInfo"
        },
        success: function (data) {
            $(".outputData").html(data);
        }
    });
}

function getInfo(){
    $.ajax({
        url: "../scripts/action.php",
        type: "POST",
        dataType: "json",
        data:{
            method: "getInfo",
            login: valLogin
        },
        success: function (data) {
            $("#login").val(data.login);
            login = data.login;
            $("#password").val(data.pass);
            password = data.pass;
            $("#email").val(data.email);
            email = data.email;
            $("#name_user").val(data.name);
            name = data.name;
            $("#btn_sign_up").hide();
            $("#btn_update").show();

        }
    });
}

$(".btn_delete_user").click(function (e) {
    e.preventDefault();
    $.ajax({
       url: "../scripts/action.php",
        type: "POST",
        data:{
           method: "delete",
           login: valLogin
        },
        success: function (data) {
            $(".outputData").html(data);
        }
    });
});

$(".btn_edit_user").click(function (e) {
    e.preventDefault();
    $(".block_conf_pass").hide();
    getInfo();

});
$("#btn_update").click(function (e) {
   e.preventDefault();
    if (StringMoreSymbols(login, 6) && StringMoreSymbols(name, 2) && IsEmail(email)) {
        $.ajax({
            url: "../scripts/action.php",
            type: "POST",
            data: {
                method: "update",
                new_login: login,
                new_password: password,
                new_email: email,
                new_name: name
            },
            success: function (data) {
                viewDataUser();
                $("#btn_sign_up").show();
                $("#btn_update").hide();
                $(".block_conf_pass").show();
                clearField();
            }
        });
    }
});

function clearField() {
    $("#login").val('');
    $("#login-auth").val('');
    $("#password").val('');
    $("#password-auth").val('');
    $("#email").val('');
    $("#name_user").val('');
}

$("#btn-admin").click(function () {
   window.open("../Admin.php")
});

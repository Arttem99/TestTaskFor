var login;
var password;
var name;
var email;

document.addEventListener("DOMContentLoaded", isUser);

function StringMoreSymbols(string, length) {
    if (string.length < length) {
        return false;
    } else {
        return true;
    }
}

function IsLoginValid(login) {
    // var regex = /^[а-яА-ЯёЁa-zA-Z0-9]+$/;
    var regex = /^[а-яА-ЯёЁa-zA-Z0-9]{6,}$/;
    if (!regex.test(login)) {
        return false;
    } else {
        return true;
    }
}

$('body').on('change', '#login', function (e) {
    e.preventDefault();
    if (!IsLoginValid($('#login').val())) {
        $('#err_login').fadeIn().html('Логин должен состоять минимум из 6 символов! Логин должен сожержать только буквы и цифры');
        setTimeout(function () {
            $('#err_login').fadeOut("Slow");
        }, 4000);
    } else {
        login = $('#login').val();
    }
});

$('#password').change(function (e) {
    e.preventDefault();
    if (isPassword($('#password').val())) {
        password = $('#password').val();
    } else {
        $('#err_pass').fadeIn().html('Пароль должен состоять минимум из 6 символов, обязательно должны содержать цифру, буквы в разных регистрах и спец символ (знаки)!');
        setTimeout(function () {
            $('#err_pass').fadeOut("Slow");
        }, 4000);
    }
});

function isPassword(password) {
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
    if (!regex.test(password)) {
        return false;
    } else {
        return true;
    }
}

$('#comf_pass').change(function (e) {
    e.preventDefault();
    if (!IsMatchingPasswords()) {
        $('#err_confpass').fadeIn().html('Пароли не совпадают!');
        setTimeout(function () {
            $('#err_confpass').fadeOut("Slow");
        }, 4000);
    }
});

function IsMatchingPasswords() {
    if (StringMoreSymbols($('#password').val(), 6) && StringMoreSymbols($('#comf_pass').val(), 6))
        if ($('#comf_pass').val() != $('#password').val()) {
            return false;
        } else {
            return true;
        }
}

function IsValidName(name) {
    var regex = /^[а-яА-ЯёЁa-zA-Z0-9]{2,}$/;
    if (!regex.test(name)) {
        return false;
    } else {
        return true;
    }
}

$('#name_user').change(function (e) {
    e.preventDefault();
    if (IsValidName($('#name_user').val())) {
        name = $('#name_user').val();
    } else {
        $('#err_user').fadeIn().html('Имя должено содежать минимум 2 символа из букв и цифр');
        setTimeout(function () {
            $('#err_user').fadeOut("Slow");
        }, 4000);
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
$('#email').change(function (e) {
    e.preventDefault();
    if (IsEmail($('#email').val()) == false) {
        $('#err_email').fadeIn().html('Введите емайл верно!');
        setTimeout(function () {
            $('#err_email').fadeOut("Slow");
        }, 4000);
    } else {
        email = $('#email').val();
    }
});
$(".registration").hide();

$("#isRegistration").click(function () {
    $(".registration").hide();
    $(".authorization").show();
    $("#isRegistration").not(this).each(function () {
        this.checked = false;
    });
    if (this.checked) {
        $(".registration").show();
        $(".authorization").hide();
    }
});


$('body').on('click', '#btn_sign_up', function (e) {
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
                    $(".user").html("Hello " + data.user);
                    $(".data-user").show();
                    isUser();
                    viewDataUser();
                    clearField();
                }
            }
        });
    } else {
        $('#error').fadeIn().html('Заполните все поля!!!');
        setTimeout(function () {
            $('#error').fadeOut("Slow");
        }, 4000);
    }
});

function definitionField(field, string) {
    if (field == "login") {
        $('#err_login').fadeIn().html(string);
        setTimeout(function () {
            $('#err_login').fadeOut("Slow");
        }, 4000);
    } else if (field == "email") {
        $('#err_email').fadeIn().html(string);
        setTimeout(function () {
            $('#err_email').fadeOut("Slow");
        }, 4000);
    } else if (field == "password") {
        $('#err_pass').fadeIn().html(string);
        setTimeout(function () {
            $('#err_pass').fadeOut("Slow");
        }, 4000);
    }
}


$("#btn_log_in").click(function (e) {
    e.preventDefault();
    if ($(".block_auth #login-auth").val().length != 0 && $(".block_auth #password-auth").val().length != 0) {
        $.ajax({
            url: "../scripts/action.php",
            type: "Post",
            dataType: "json",
            data: {
                method: "authorization",
                login: $("#login-auth").val(),
                password: $("#password-auth").val()
            },
            success: function (data) {
                // alert(data);
                if (data.result == "true") {
                    $(".user").html("Hello " + data.user);
                    $(".data-user").show();
                    $(".div_field").hide();
                    clearField();
                } else {
                    $('#error').fadeIn().html(data.string);
                    setTimeout(function () {
                        $('#error').fadeOut("Slow");
                    }, 4000);
                }
            }

        });

    } else {
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
        type: "Post",
        data: {
            method: "exit"
        },
        success: function (data) {
            $(".user").html(data);
            isUser();
        }
    });
});

function isUser() {
    $("#btn_update").hide();
    if ($(".user").html() != "") {
        $(".div_field").hide();
        // $("#isRegistration").hide();
    } else {
        $(".data-user").hide();
        $(".authorization").show();
        $(".block_check").show();
    }
}


var valLogin;

function viewDataUser() {
    $.ajax({
        url: "../scripts/action.php",
        type: "POST",
        data: {
            method: "viewInfo"
        },
        success: function (data) {
            $(".outputData").html(data);
        }
    });
}

function getInfo() {
    $.ajax({
        url: "../scripts/action.php",
        type: "POST",
        dataType: "json",
        data: {
            method: "getInfo",
            login: valLogin
        },
        success: function (data) {
            $("#login").val(data.login);
            login = data.login;
            $("#password").val(data.password);
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

$("body").on('click', '.btn_delete_user', function (e) {
    e.preventDefault();
    var button = e.target;
    valLogin = button.value;
    $.ajax({
        url: "../scripts/action.php",
        type: "POST",
        data: {
            method: "delete",
            login: valLogin
        },
        success: function () {
            // $(".outputData").html(data);
            viewDataUser();
        }
    });
});

$("body").on('click', '.btn_edit_user', function (e) {
    e.preventDefault();
    var button = e.target;
    valLogin = button.value;
    $(".block_conf_pass").hide();
    getInfo();
});

$("body").on('click', '#btn_update', function (e) {
    e.preventDefault();
    if (IsValidName(name) && IsLoginValid(login) && IsEmail(email)) {
        $.ajax({
            url: "../scripts/action.php",
            type: "POST",
            dataType: "json",
            data: {
                method: "update",
                old_login: valLogin,
                new_login: login,
                new_password: password,
                new_email: email,
                new_name: name
            },
            success: function (data) {
                if (data.result != "false") {
                    viewDataUser();
                    $("#btn_sign_up").show();
                    $("#btn_update").hide();
                    $(".block_conf_pass").show();
                    clearField();
                } else {
                    definitionField(data.field, data.string);
                }


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

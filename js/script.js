var login;
var password;
var name;
var email;

function StringMoreSymbols(string, length) {
        if (string.length < length){
            return false;
        }
        else {
            return true;
        }
}

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


$('#password').change(function () {
    if (!StringMoreSymbols($('#password').val(), 6)){
        $('#err_pass').fadeIn().html('Пароль должен состоять минимум из 6 символов!');
        setTimeout(function () {
            $('#err_pass').fadeOut("Slow");
        }, 4000);
    }
    else {
        password = $('#password').val();
    }
});

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
        if (StringMoreSymbols(login, 6) && StringMoreSymbols(name, 2) && IsMatchingPasswords() && IsEmail(email)) {
            $.ajax({
                url: "../scripts/function.php",
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

$(".update #btn_update_user").click(function (e) {
    e.preventDefault();
    $.ajax({
       url: "../scripts/function.php",
       type: "POST",
        data:{
           method:"update",
           login: $(".update #login").val(),
           password: $(".update #password").val(),
           email: $(".update #email").val(),
           name: $(".update #name").val()
        }
    });

});

$("#btn_log_in").click(function (e) {
    e.preventDefault();
    if ($(".block_auth #login-auth").val().length != 0 && $(".block_auth #password-auth").val().length !=0){

        $.ajax({
           url:"../scripts/function.php",
            type:"Post",
            dataType: "json",
            data:{
               method: "authorization",
                login: $(".block_auth #login-auth").val(),
                password: $(".block_auth #password-auth").val()
            },
            success: function (data) {
                if (data.result == "true"){
                    $(".user").html("Hello " +data.user["0"]);
                    $(".data-user").show();

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
       url: "../scripts/function.php",
       type:"Post",
       data:{
           method:"exit"
       }
   });
});

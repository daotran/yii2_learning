$(document).ready(function() {

	//open popup when clicking login link at top right - header
    $(".log-buttons .login-link").click(function(e) {
        e.preventDefault();alert("fdsf");
        show_login_popup();
    });

    $(".cross_img").click(function() {
        hide_login_popup();
    });

    login_register_url_handler();
    login_form_handler();
});

function show_login_popup() {
    //getRelevantRegisterTitle();
    show_popup(".popup-div");
}
function hide_login_popup() {
    hide_popup(".popup-div");
}

function show_popup(obj) {
	// centering popup
    //$(".popup-div .body-popup").center();
    $(obj).css('visibility', 'visible');
}
function hide_popup(obj) {
	// centering popup
   // $(".popup-div .body-popup").center();
    $(obj).css('visibility', 'hidden');
}

/**
 * Get url param
 **/
function getUrlParam(key) {
    var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search);
    return result && unescape(result[1]) || "";
}

/**
 * show login page when user go to the url with '?showlogin=true'
 **/
function login_register_url_handler() {
    if (getUrlParam('showlogin')) { 
        show_login_popup();
    } else if (getUrlParam('showregister')) {        
        show_register_popup();
    }
}

/**
 * Login form handler
 **/
function login_form_handler() {
    // login form handler
    $("#login-form .remember-label").click(function() {
        //check and turn on rememberMe value
        if ($("#login-form .remember-label").hasClass("chosen")) {
            $("#login-form .remember-label").removeClass("chosen");
            $("#login-form .remember-label").removeClass("selector");
            $("[name='LoginForm[rememberMe]']").prop('checked', false);
            $("[name='LoginForm[rememberMe]']").val(0);
        } else {
            $("#login-form .remember-label").addClass("chosen");
            $("#login-form .remember-label").addClass("selector");
            $("[name='LoginForm[rememberMe]']").prop('checked', true);
            $("[name='LoginForm[rememberMe]']").val(1);
        }
    });
    //call ajax to login when click login button
    $("#login_btn").click(function() {
        // ajax to get back the error message if hae
        //var loginUrl = globalVar['base_url'] + "site/login";
        //var loginUrl = $('#login-form').attr('action');
        var loginUrl = 'http://localhost/yii2_learning/web/site/login';
        var uemail = $('#login-form .user-email').val();
        var upassword = $('#login-form .user-pwd').val();
        var urememberMe = $('#login-form .user-remember').val(); alert("fdxxxsf");
        var register_cf = $("#login-form [name='_csrf']").val();
        if ((uemail == '') || (upassword == '')) {
            alert(messages['error.login.missing_email_pass']);
        } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(uemail)) {
            alert(messages['error.common.incorrect_email']);
        } else {
            $('#login-form .action-loading').css('display', 'inline');
            $('#login-form .action-loading').show();

            $.post(loginUrl, {
                    // ajax_login_popup: 'check_login_info',
                    'LoginForm[username]': uemail,
                    'LoginForm[password]': upassword,
                    'LoginForm[rememberMe]': urememberMe,
                    _csrf: register_cf,
                }).done(function(data) {
                    if (data['status'] == 'error') { // alert the error
                        $('#login-form .action-loading').hide();
                        if (data['message'] == 'not existed email') {
                            alert(messages['error.login.not_registered_email']);
                        } else {
                            // alert(messages['error.login.can_not_login']);
                            alert(data['message']);
                        }
                        return false;
                    } else if (data['status'] == 'ok') { // redirect if okie
                        if (!!globalVar['callbackAfterLogin']) {
                            globalVar['notloggedin'] = false;
                            var callbackFunction = globalVar['callbackAfterLogin'];
                            globalVar['callbackAfterLogin'] = null;
                            hide_login_popup();
                            callbackFunction();
                        } else {
                            window.location.replace(data['url']);
                        }
                    }
                }
            )/*.fail(function(e) {
                alert("fail".e);
            })*/;
        }
        return false;
    });
}
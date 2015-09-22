/**
 * Login/register/reset password handler
 **/

/* Login with Facebook section */
window.fbAsyncInit = function() {
    FB.init({
        appId: globalVar['FBClientID'],
        cookie: true, // enable cookies to allow the server to access 
        // the session
        xfbml: true, // parse social plugins on this page
        version: 'v2.2' // use version 2.2
    });

};

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));


// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
    if (response.status === 'connected') {
        // Logged into your app and Facebook.
        fbCallbackAPI();
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        fb_login();
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        fb_login();
    }
}

// This function is called when someone finishes with the Login
// Button.
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function fbCallbackAPI() {
    FB.api('/me?fields=id,name,email', function(response) {
        if (response.hasOwnProperty('email')) { 
            // redirect after successfully login on fb
            window.location.href = globalVar['base_url'] + 'site/auth?authclient=facebook';
        } else {
            alert(messages['info.fb_login.message']);
        }
    });
    
}

function fb_login() {
    FB.login(function(response) {
        if (response.authResponse) {
            checkLoginState();
        }
        //checkLoginState();
    },{scope: 'email'});
    // FB.Event.subscribe('auth.login',checkLoginState);
}
/* Login with Facebook section */

$(document).ready(function() {

    // facebook login
    $('.login_fb_btn').click(function() {
        FB.login(function(response) {
            if (response.authResponse) {
                checkLoginState();
            }
            //checkLoginState();
        },{scope: 'email'});
    });

    //open popup when clicking login link at top right - header
    $(".log-buttons .login-link").click(function(e) {
        e.preventDefault();
        show_login_popup();
    });

    //open popup when clicking register link at top right - header
    $('.log-buttons .register-link').click(function(e) {
        e.preventDefault();
        show_register_popup();
    });

    $(".cross_img").click(function() {
        hide_login_popup();
        hide_gender_popup();
        hide_register_popup();
        hide_forgot_password_popup();
    });

    //choose to open login from register 
    $('.popup-div-register .popup-login').click(function() {
        hide_register_popup();
        show_login_popup();
        return false;
    });
    $('.popup-div-gender .popup-login').click(function() {
        hide_gender_popup();
        show_login_popup();
        return false;
    });

    //choose to open register from login 
    $('.popup-div .popup-register').click(function() {
        hide_login_popup();
        show_register_popup();
        return false;
    });

    $('#forgot-password-form .popup-login').click(function() {
        hide_forgot_password_popup();
        show_login_popup();
        return false;
    });

    //go back to email register page
    $(".popup-div-gender .change-email").click(function() {
        hide_gender_popup();
        show_register_popup();
        return false;
    });

    //show forgot password when clicking on forgot pass on login
    $(".popup-div-gender .change-email").click(function() {
        hide_gender_popup();
        show_register_popup();
        return false;
    });

    // choose to open register from login popup
    $('#login-form .forgot-pass-link').click(function() {
        hide_login_popup();
        show_forgot_password_popup();
        return false;
    });

    login_register_url_handler();
    login_form_handler();
    register_form_handler();
    forgot_password_handler();
    
    // centering popup
    $(".popup-div .body-popup").center();
    $(".popup-div-register .body-popup").center();
    $(".popup-div-gender .body-popup").center();
    $(".forgot-password-form .body-popup").center();

    $( window ).resize(function() {
        // centering popup
        $(".popup-div .body-popup").center();
        $(".popup-div-register .body-popup").center();
        $(".popup-div-gender .body-popup").center();
        $(".forgot-password-form .body-popup").center();
    });
    var lastPos = 0;
    $( window ).scroll(function() {
        var currPos = $(document).scrollLeft();

        if (lastPos < currPos) {
            // centering popup
            $(".popup-div .body-popup").center();
            $(".popup-div-register .body-popup").center();
            $(".popup-div-gender .body-popup").center();
            $(".forgot-password-form .body-popup").center();
        }
        if (lastPos > currPos) {
            // centering popup
            $(".popup-div .body-popup").center();
            $(".popup-div-register .body-popup").center();
            $(".popup-div-gender .body-popup").center();
            $(".forgot-password-form .body-popup").center();
        }
        lastPos = currPos;
    });
});

function show_login_popup() {
    getRelevantRegisterTitle();
    show_popup(".popup-div");
}

function hide_login_popup() {
    hide_popup(".popup-div");
}

function show_register_popup() {
    show_popup('.popup-div-register');
}

function hide_register_popup() {
    hide_popup('.popup-div-register');
}

function show_gender_popup() {
    show_popup('.popup-div-gender');
}

function hide_gender_popup() {
    hide_popup('.popup-div-gender');
}

function show_forgot_password_popup() {
    show_popup('.forgot-password-form');
}

function hide_forgot_password_popup() {
    hide_popup('.forgot-password-form')
}

function show_popup(obj) {
    // centering popup
    $(".popup-div .body-popup").center();
    $(".popup-div-register .body-popup").center();
    $(".popup-div-gender .body-popup").center();
    $(".forgot-password-form .body-popup").center();
    // $(obj).css('display', 'block');
    $(obj).css('visibility', 'visible');
    $(".window-mask").show();
}

function hide_popup(obj) {
    // $(obj).css('display', 'none');
    $(obj).css('visibility', 'hidden');
    $(".window-mask").hide();
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
        hide_register_popup();
        hide_gender_popup();
        hide_forgot_password_popup();
        show_login_popup();
    } else if (getUrlParam('showregister')) {
        hide_login_popup();
        hide_gender_popup();
        hide_forgot_password_popup();
        show_register_popup();
    }
}

function getRelevantRegisterTitle() {
    // to show relevant text on register
    var current_url = window.location.href;
    if(current_url.indexOf("?from=sale") > -1) {
        $(".popup-div-register .get_exclusive").html(messages['info.register.sale_title']);
    } else if(current_url.indexOf("?from=whats-new") > -1){
        $(".popup-div-register .get_exclusive").html(messages['info.register.whatnew_title']);
    } else if(current_url.indexOf("sell/sell-us") > -1){
        $(".popup-div-register .get_exclusive").html(messages['info.register.submission']);
    } else {
        if($("#add_to_favourite").length > 0) { /*add to wishlist*/
            $(".popup-div-register .get_exclusive").html(messages['info.register.add_to_wishlist']);
        } else if ($("#save-search").length == 0) { /*normal registration title*/
            $(".popup-div-register .get_exclusive").html(messages['info.register.normal_title']);
        }
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
        var loginUrl = $('#login-form').attr('action');
        var uemail = $('#login-form .user-email').val();
        var upassword = $('#login-form .user-pwd').val();
        var urememberMe = $('#login-form .user-remember').val();
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
                    _csrf: register_cf
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

function is_register_popup() {
    // if (($(".popup-div-register").css("display") == "none") && ($(".popup-div-gender").css("display") == "none")) {
    if (($(".popup-div-register").css("visibility") == "hidden") && ($(".popup-div-gender").css("visibility") == "hidden")) {
        return false;
    } else {
        return true;
    }
}

/**
 * Register handler
 **/
function register_form_handler() {
    /* next buton handler */
    $(".next-to-gender").click(function() {
        var loginUrl = globalVar['base_url'] + "site/register";
        var isRegisterPopup = is_register_popup();
        if (isRegisterPopup) { //get data from popup
            var uemail = $('.popup-div-register .user-email').val();
            var register_cf = $("#register-form [name='_csrf']").val();
        } else { // get data from homepage
            var uemail = $('#register-front-form .user-email').val();
            var register_cf = $("#register-front-form [name='_csrf']").val();
        }

        if (uemail == '') {
            alert(messages['error.common.not_enter_email']);
        } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(uemail)) {
            alert(messages['error.common.incorrect_email']);
        } else {
            if (isRegisterPopup) {
                $('.popup-div-register .action-loading').css('display', 'inline');
                $('.popup-div-register .action-loading').show();
            }

            $.post(loginUrl, {
                    ajax_login_popup: 'check_exist_email',
                    'SignupForm[email]': uemail,
                    type: 'email',
                    _csrf: register_cf
                },
                function(data) {
                    if (isRegisterPopup) {
                        $('.popup-div-register .action-loading').hide(); // hide the action loading gif
                    }

                    if (data['status'] == 'error') { //existed email
                        alert(data['message']);
                    } else { //email is not exist, can process next step
                        // alert("next step , " + uemail)
                        if (isRegisterPopup) { // for popup
                            hide_register_popup();
                            show_gender_popup();
                        } else { //for homepage
                            $("#register-front-form .email-form").addClass("hidden");
                            $("#register-front-form .gender-form").removeClass("hidden");
                        }

                    }
                }
            ).fail(function(e) {
                alert("fail".e);
            });
        }
        return false;
    });

    /* sign up button handler */
    $(".register_btn").click(function() {
        // get data
        var loginUrl = globalVar['base_url'] + "site/register";
        if (is_register_popup()) {
            var uemail = $('#register-form .user-email').val();
            var upassword = $('#register-form .user-pwd').val();
            var register_cf = $("#register-form [name='_csrf']").val();
            var ugender = 1;
            // get gender data
            if ($("#squaredOne-pop1:checked").length) { //choose Female
                ugender = $("#squaredOne-pop1").val();
            }
        } else {
            var uemail = $('#register-front-form .user-email').val();
            var upassword = $('#register-front-form .user-pwd').val();
            var register_cf = $("#register-front-form [name='_csrf']").val();
            var ugender = 1;
            // get gender data
            if ($("#squaredOne-pop1-front:checked").length) { //choose Female
                ugender = $("#squaredOne-pop1-front").val();
            }
        }

        if (upassword == '') { //validate password -> can not be empty
            alert(messages['error.common.not_enter_password']);
        } else if (upassword.length < 6) { // validate password -> can not least than 6 characters
            alert('Password length has to be at least 6 characters.');
        } else {
            $('.popup-div-gender .action-loading').css('display', 'inline');
            $('.popup-div-gender .action-loading').show();
            $.post(loginUrl, {
                    'SignupForm[email]': uemail,
                    'SignupForm[password]': upassword,
                    'SignupForm[gender]': ugender,
                    type: 'gender',
                    _csrf: register_cf
                },
                function(data) {
                    if (data['status'] == 'error') { // alert the error
                        $('.popup-div-gender   .action-loading').hide(); // hide the action loading gif
                        alert("Register information is incorrect. Please re-key");
                        return false;
                    } else if (data['status'] == 'ok') { // redirect to homepage if okie
                        if (!!globalVar['callbackAfterLogin']) {
                            var callbackFunction = globalVar['callbackAfterLogin'];
                            globalVar['callbackAfterLogin'] = null;
                            hide_login_popup();
                            hide_gender_popup();
                            hide_register_popup();
                            callbackFunction();
                            //globalVar['callbackAfterLogin']();
                        } else {
                            alert(messages['info.register.success'] + uemail);
                            window.location.replace(data['url']);
                        }
                    }
                }
            ).fail(function(e) {
                alert("Can not process register");
            });
        }
        return false;
    });
}

/**
 * Forgot password handler
 **/
function forgot_password_handler() {
    $("#forgot_password_btn").click(function() {
        var loginUrl = globalVar['base_url'] + "site/request-password-reset";
        var uemail = $('#forgot-password-form .user-email').val();
        var register_cf = $("#forgot-password-form [name='_csrf']").val();
        if (uemail == '') {
            alert(messages['error.common.not_enter_email']);
        } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(uemail)) {
            alert(messages['error.common.incorrect_email']);
        } else {
            $.post(loginUrl, {
                    'PasswordResetRequestForm[email]': uemail,
                    _csrf: register_cf
                },
                function(data) {
                    if (data['status'] == 'error') { // alert the error
                        alert(data['message']);
                        return false;
                    } else if (data['status'] == 'ok') { // redirect if okie
                        alert(messages['info.forgotpass.submit']);
                        window.location.replace(data['url']);
                    }
                }
            ).fail(function(e) {
                alert("fail".e);
            });
        }
        return false;
    });
}
jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top", Math.max(0, (($(window).height() - $(this).height()) / 2) + $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
    return this;
}
/**
 * Reset password handler
 **/
// function reset_password_handler() {
//   $("#reset-password-form .save_pass").click(function(){
//     var result = true;
//     var new_password = $("#new_password").val();
//     var confirm_password = $("#confirm_password").val();
//     if((new_password == '') || (confirm_password == '')){
//       result =  false;
//       alert("Please enter both new password and confirm password.");
//     }
//     else if((new_password.length<6) || (confirm_password.length<6)){
//       result =  false;
//       alert("Password has to contain at least 6 characters in length");
//     }
//     else if(new_password != confirm_password) {
//       result =  false;
//       alert("New Password doesn't match with Confirm Password");
//     }
//     return result;
//   });
// }
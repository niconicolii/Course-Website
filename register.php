<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <title></title>
</head>
<body>
<div id="main_block">
    <div id="login_wrapper">
        <div id="login_block">
            <img id="login_img" src="img/login_logo.png">
            <div id="heading_text">
                Register
            </div>
            <p>with your utorid and email</p>
            <form id="register_form" onsubmit="return false;" autocomplete="off">
                <input id="register" autocomplete="off" name="hidden" type="text"
                       style="display:none">
                <div id="login_form">
                    <div class="input_field">
                        <input id="user_field" type="text" placeholder="Your Utorid"
                               onfocus="showAnimation(this)" onblur=
                               "hideAnimation(this)" name="userid" required/>
                    </div>
                    <div class="input_field">
                        <input id="psw_field" type="password"
                               placeholder="Your Password"
                               onfocus="showAnimation(this)" onblur=
                               "hideAnimation(this)" name="psw" required/>
                    </div>
                    <div class="input_field">
                        <input id="confirm_field" type="password"
                               placeholder="Comfirm Your Password"
                               onfocus="showAnimation(this)" onblur=
                               "hideAnimation(this)" required/>
                    </div>
                    <div class="input_field">
                        <input id="email_field" type="email" placeholder="Your Email"
                               onfocus="showAnimation(this)" onblur=
                               "hideAnimation(this)" name="email" required/>
                    </div>
                    <div>
                        <span style="color: #808689; font-size: 12px">I am a/an </span>
                        <select id="role_field">
                            <option value="Student">Student</option>
                            <option value="TA">TA</option>
                            <option value="Instructor">Instructor</option>
                        </select>
                    </div>
                    <a href="login.php">Back to login</a>
                    <button id="button_field" class="tran" value="Register" onclick="registerVerify()">Register</button>
                    <div id="hint"></div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="js/login.js"></script>
</html>

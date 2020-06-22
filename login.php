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
                Login in
            </div>
            <p>with your utorid</p>
            <form id="login" onsubmit="return false" method="post" autocomplete="off">
                <input autocomplete="off" name="hidden" type="text"
                       style="display:none">
                <div id="login_form">
                    <div class="input_field">
                        <input id="username" type="text" placeholder="Your Utorid"
                               onfocus="showAnimation(this)" onblur=
                               "hideAnimation(this)" name="userid" required/>
                    </div>
                    <div class="input_field">
                        <input id="password" type="password" placeholder="Your Password"
                               onfocus="showAnimation(this)" onblur=
                               "hideAnimation(this)" name="psw" required/>
                    </div>
                    <div id="register_field">
                        <a href="register.php">Don't have an account yet?</a>
                    </div>
                    <input type="submit" id="button_field" class="tran"
                           value="Login in" onclick="loginVerify()"/>
                        <?php
                            if(isset($_GET["auth"])) {
                                ?>
                                <div style="color: red; font-size: x-small" id="hint">
                                    Please login with the correct authority.
                                </div>
                                <?php
                            }else{
                                echo "<div id='hint'></div>";
                            }
                        ?>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="js/login.js"></script>
</html>

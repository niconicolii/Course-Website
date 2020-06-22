/**
 * Created by lichi on 2018/4/1.
 */
function showAnimation(element){
    let selected_field = element.parentElement;
    window.setTimeout(function(){
        selected_field.style.borderBottomColor = "#1a8ed5";
    },100);
}
function hideAnimation(element){
    let selected_field = element.parentElement;
    window.setTimeout(function(){
        selected_field.style.borderBottomColor = "#dddddd";
    },100);
}
function registerVerify(){
    let register = document.getElementById("register_form");
    let psw = document.getElementById("psw_field").value;
    let confirm_psw = document.getElementById("confirm_field");
    if(psw != confirm_psw.value){
        confirm_psw.setCustomValidity("Please enter the same password as above!");
    } else if (register.checkValidity()) {
        let userid = document.getElementById("user_field").value;
        let email = document.getElementById("email_field").value;
        let role = document.getElementById("role_field").value;
        let jsonString = JSON.stringify({"userid": userid, "psw": psw,
            "email": email, "role": role});
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText == "true") {
                    document.getElementById("hint").innerHTML =
                        "<p style='color: green; font-size: x-small'>Register" +
                        " succeed, Redirecting...</p>"
                    window.setTimeout(function(){
                        window.location.href = "index.php";
                    },100);
                }else{
                    document.getElementById("hint").innerHTML = this.responseText;
                }
            }
        };
        xhttp.open("POST", "validate/register_validation.php?user=" +jsonString, true);
        xhttp.send();
    }
}
function loginVerify(){
    let loginForm = document.getElementById("login");
    if(login.checkValidity()){
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;
        let jsonString = JSON.stringify({"username": username, "password": password});
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if(this.responseText == "true") {
                    document.getElementById("hint").innerHTML =
                        "<p style='color: green; font-size: x-small'>Login" +
                        " succeed, Redirecting...</p>";
                    window.setTimeout(function(){
                        window.location.href = "index.php";
                    },100);
                }else{
                    document.getElementById("hint").innerHTML = this.responseText;
                }
            }
        };
        xhttp.open("POST", "validate/login_validation.php?user=" +jsonString, true);
        xhttp.send();
    }
}

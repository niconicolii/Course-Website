function submitRemark(id){
    let userid = document.getElementById('userID').innerHTML;
    let workid = id;
    let description = document.getElementById(id+'reason').value;
    let markerid = document.getElementById('sentTo').value;
    let jsonString = JSON.stringify({"userID": userid, "workID": workid, "description": description, "markerID": markerid});
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            if (this.responseText == 'true') {
                alert("Request submitted!");
                location.reload();
            } else {
                alert("Failed!");
            }
        }
    };
    xhttp.open("POST", "validate/remark_request.php?user=" + jsonString, true);
    xhttp.send();
}


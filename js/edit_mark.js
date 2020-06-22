/**
 * Created by lichi on 2018/4/5.
 */
let curid = null;
function addNewMark(){
    let workid = document.getElementById('addWork').value;
    let percentage = document.getElementById('addMark').value;
    let userid = document.getElementById('studentID').innerHTML;
    let jsonString = JSON.stringify({"userID": userid, "workID": workid, "percentage": percentage});
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == 'true') {
                alert("New mark added!");
                location.reload();
            } else {
                alert("Failed!" + this.responseText);
            }
        }
    };
    xhttp.open("POST", "validate/editmark_new_mark.php?user=" + jsonString, true);
    xhttp.send();
}

function update(id){
    let newmarkitem = document.getElementById(id+'value');
    let newmark = parseInt(newmarkitem.value);
    let userID = document.getElementById('studentID').innerHTML;
    let jsonString = JSON.stringify({"userID": userID, "workID": workID, "newmark": newmark});
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == 'false') {
                alert("Update Failed.");
            } else {
                alert("Mark updated!");
                document.getElementById(id+'date').innerHTML = this.responseText;
            }
        }
    };
    xhttp.open("POST", "validate/edit_db_update.php?user=" + jsonString, true);
    xhttp.send();
}

function updateNewTask(){
    let form = document.getElementById('newWork');
    if(form.checkValidity()){
        let element = document.getElementById('newWork').elements;
        let workid = element.namedItem('newWorkID').value;
        let type = element.namedItem('workType').value;
        let startdate = element.namedItem('startDate').value;
        let starttime = element.namedItem('startTime').value;
        let start = startdate + " " + starttime + ":00";
        let enddate = element.namedItem('endDate').value;
        let endtime = element.namedItem('endTime').value;
        let end = enddate + " " + endtime + ":00";
        let weight = element.namedItem('weight').value;
        let jsonString = JSON.stringify({"workID": workid, "type": type, "starttime": start, "endtime": end, "weight": weight});
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let hint = document.getElementById("hint");
                if (JSON.parse(this.responseText)["result"] == true) {
                    hint.style.color = "green";
                    hint.innerText = "Succeed!";
                    if (curid !== null){
                        updateMark(curid);
                    }
                } else {
                    hint.style.color = "red";
                    hint.innerText = "Failed!";
                }
            }
        };
        xhttp.open("POST", "validate/editmark_new_task.php?user=" + jsonString, true);
        xhttp
        xhttp.send();
    }
}
function updateMark(id){
    let xhttp = new XMLHttpRequest();
    let userid = id;
    let jsonString = JSON.stringify({"id": userid});
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let hint = document.getElementById("edit_hint");
            console.log(this.responseText);
            let arr = JSON.parse(this.responseText);
            if(arr["result"]){
                displayMarks(userid, arr["works"]);
                hint.innerText = "";
                curid = userid;
            } else {
                hint.style.color = "red";
                hint.innerText = "Can not find such student";
            }
        }
    };
    xhttp.open("POST", "validate/find_mark.php?mark=" + jsonString, true);
    console.log(xhttp.location);
    xhttp.send();
}
function showMark(){
    let form = document.getElementById("utorid");
    if(form.checkValidity()){
        updateMark(form.elements.namedItem("searchID").value);
    }
}
function displayMarks(id, marks){
    clearMarks();
    let wrapper = document.createElement("div");
    wrapper.className += "component mark_table";
    wrapper.style.opacity = "0";
    let h2 = document.createElement("h2");
    h2.innerText = id;
    wrapper.appendChild(h2);
    let innerWrapper = document.createElement("div");
    innerWrapper.className += "mock-table-border";
    let row = document.createElement("div");
    row.className += "row grid-2";
    row.appendChild(htmlToElement("<div class='col'><b>WorkID</b></div>"));
    row.appendChild(htmlToElement("<div class='col'><b>Mark</b></div>"));
    innerWrapper.appendChild(row);
    for (let key in marks) {
        let mark = marks[key];
        if (mark === null){
            mark = "N/A";
        }else{
            mark += "%"
        }
        row = document.createElement("div");
        row.className += "row grid-2";
        row.appendChild(htmlToElement("<div class='col'>"+key+"</div>"));
        row.appendChild(htmlToElement("<div class='col' id='"+key+"'>"+mark+"</div>"));
        innerWrapper.appendChild(row);
    }
    wrapper.appendChild(innerWrapper);
    document.getElementById("find_mark").insertAdjacentElement('afterend', wrapper);
    wrapper.style.transition = "opacity 1000ms linear";
    setTimeout(function() {
        wrapper.style.opacity = "1";
    }, 100);
}

function addMark(){
    let form = document.getElementById("update_info");
    if(form.checkValidity()){
        let userid = form.elements.namedItem("utorid").value;
        let workid = form.elements.namedItem("workid").value;
        let mark = form.elements.namedItem("mark").value;
        let xhttp = new XMLHttpRequest();
        let jsonString = JSON.stringify({"userid": userid, "workid": workid, "mark": mark});
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let hint = document.getElementById("update_hint");
                console.log(this.responseText);
                let arr = JSON.parse(this.responseText);
                if(arr["result"]){
                    hint.style.color = "green";
                    hint.innerText = "Update succeed.";
                    if(userid == curid){
                        document.getElementById(workid).innerText = mark += "%";
                    }
                } else {
                    hint.style.color = "red";
                    hint.innerText = "Can not find such student, or the workid does not exist.";
                }
            }
        };
        xhttp.open("POST", "validate/update_mark.php?mark=" + jsonString, true);
        xhttp.send();
    }
}

function htmlToElement(html) {
    var template = document.createElement('template');
    html = html.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;
    return template.content.firstChild;
}
function clearMarks(){
    let feedback = document.getElementsByClassName("mark_table");
    for (let i = 0; i < feedback.length; i++){
        removeFadeOut(feedback[i], 1000)
    }
}
function removeFadeOut( el, speed ) {
    var seconds = speed/1000;
    el.style.transition = "opacity "+seconds+"s ease";
    el.style.opacity = 0;
    setTimeout(function() {
        el.parentNode.removeChild(el);
    }, speed);
}

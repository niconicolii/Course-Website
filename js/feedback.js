/**
 * Created by lichi on 2018/4/3.
 */
function uploadFeedback(feedbackDict, time, isInstructor){
    if(isInstructor){
        href = "html_templates/instructor_feedback.html";
    }else{
        href = "html_templates/student_feedback.html"
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("GET", href, true);
    xmlhttp.send();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let newContent = generateFeedback(feedbackDict, time, isInstructor,
                htmlToElement(this.responseText));
            newContent.style.opacity = '0';
            newContent.classList.add('opacity_animated');
            if(isInstructor){
                document.getElementById("feedback_date").insertAdjacentElement('afterend', newContent);
            }else{
                document.getElementById("feedback-submit").insertAdjacentElement('beforebegin', newContent);
            }
            window.setTimeout( function() {
                newContent.style.opacity = '1';
            }, 100);
        }
    };

}

function generateFeedback(feedbackDict, time, isInstructor, template){
    let answers = template.querySelectorAll("div.ans");
    if(isInstructor){
        template.querySelector("h2").innerText = "Posted On " + time;
        answers[0].innerText = feedbackDict["Qa"];
        answers[1].innerText = feedbackDict["Qb"];
        answers[2].innerText = feedbackDict["Qc"];
        answers[3].innerText = feedbackDict["Qd"];
    } else {
        template.querySelector("h2").innerText = "To " + feedbackDict["e"];
        answers[0].innerText = feedbackDict["a"];
        answers[1].innerText = feedbackDict["b"];
        answers[2].innerText = feedbackDict["c"];
        answers[3].innerText = feedbackDict["d"];
        let date = template.querySelector("div.end-text");
        date.innerText = "Posted on " + time;
    }
    return template;
}
function submitFeedback(){
    let feedback = document.getElementById("feedback");
    if (feedback.checkValidity()){
        let a = feedback.elements.namedItem("a").value;
        let b = feedback.elements.namedItem("b").value;
        let c = feedback.elements.namedItem("c").value;
        let d = feedback.elements.namedItem("d").value;
        let e = feedback.elements.namedItem("e").value;
        let feedbackArr = {"a": a, "b": b, "c": c, "d": d, "e": e};
        let jsonString = JSON.stringify(feedbackArr);
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let arr = JSON.parse(this.responseText);
                if(arr["result"] == true) {
                    document.getElementById("hint").innerHTML =
                        "<p style='color: green; font-size: x-small'>" +
                        " Submit succeed.</p>";
                    uploadFeedback(feedbackArr, arr["message"], false);
                }else{
                    document.getElementById("hint").innerHTML = arr["message"];
                }
            }
        };
        xhttp.open("POST", "validate/feedback_validation.php?feedback=" +jsonString, true);
        xhttp.send();
    }
}
function htmlToElement(html) {
    var template = document.createElement('template');
    html = html.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;
    return template.content.firstChild;
}
function queryFeedback(){
    clearFeedback();
    let date = document.querySelector("input[type=date]").value;
    let limit = document.querySelector("input[type=number]").value;
    let jsonString = JSON.stringify({"date": date, "limit": limit});
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let arr = JSON.parse(this.responseText);
            if (arr.length == 0) {
                document.getElementById("hint").innerText = "There is no" +
                    " feedback at that day";
            } else {
                document.getElementById("hint").innerText = "";
                for(let i = 0; i < arr.length; i++){
                    let feedback = arr[i];
                    let date = feedback["UpdateDate"];
                    uploadFeedback(feedback, date, true);
                }
            }
        }
    };
    xhttp.open("POST", "validate/feedback_query.php?query=" + jsonString, true);
    xhttp.send();
}
function clearFeedback(){
    let feedback = document.getElementsByClassName("feedback");
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


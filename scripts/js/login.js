var errorCodes = [];


function validatePassword(val){
    document.getElementById("upload").value = "";
    document.getElementById("uploadStatus").checked = false;
    var x = val;
    var count = x.value.length;
    if(count >= 6){
        return true;
    }else{
        errorCodes.push("Password must be atleast of 6 characters.");
        return false;
    }

}

function validateEmail(val) {
    var x = val;
    var email = x.value.toString();
    const index = email.indexOf("@");
    // console.log(index + " " + email);
    if(index >= 0){
        return true;
    }else{
        errorCodes.push("Email must contain '@' in it.");
        return false;
    }
}

function userValidate(val, val1){
    console.log("Running Login Script - Validation Process");
    var count = 0;
    document.getElementById("errors").innerHTML = "";
    // console.log(document.getElementById("errors").innerHTML);
    if (validateEmail(val)) {
        count++;
    }else{
        alert("Invalid Email!");
    }

    if (validatePassword(val1)){
        count++;
    }else{
        alert("Invalid Password!");
    }

    if(count == 2){
        document.getElementById("errors").style = "color: green";
        document.getElementById("errors").innerHTML = "<br><p>Login Validated</p>";
        document.getElementById("upload").value = "1";
        document.getElementById("uploadStatus").checked = false;
        count = 0;
    }else {
        document.getElementById("errors").style = "color: red";
        for(var i = 0; i < errorCodes.length; i++){
            document.getElementById("errors").innerHTML += "<p>" + errorCodes[i] + "</p>";
            console.log(errorCodes[i]);
        }
        errorCodes = [];
        count = 0;
    }
};
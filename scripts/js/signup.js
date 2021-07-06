var uploadFlag = false;


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

function validateSignup(checkusername, checkemail, checkpassword1, checkpassword2){
    var name = checkusername.value;
    var password = checkpassword1.value;
    var rePassword = checkpassword2.value;

    if (password == rePassword){
        if (password.length >= 6){
            uploadFlag = true;
        }else{
            alert("Password too short, must be atleast of 6 characters!");
            return;
        }
    }else{
        alert("Passwords Miss-Match!");
        return;
    }

    if (validateEmail(checkemail)){
        uploadFlag = true;
    }else{
        return;
    }

    if (uploadFlag){
        document.getElementById("upload").value = 1;
        document.getElementById("uploadStatus").checked = true;
    }else{
        return;
    }
    
}
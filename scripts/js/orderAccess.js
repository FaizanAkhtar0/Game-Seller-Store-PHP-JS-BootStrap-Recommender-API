var format = /[ !`~@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;


function checkForm(item, checkcode){
    var selectedvalue = item.value;
    var code = checkcode.value;

    if (selectedvalue == "-1"){
        alert("Please choose an order first!");
        return;
    }else{
        if (!(format.test(code.trim()))){
            document.getElementById("upload").value = "1";
            document.getElementById("uploadStatus").checked = true;
        }else{
            alert("Invalid Code!");
            return;
        }
    }
}
var imageName;
var publishflag = false;
var extentions = ["gif","png","jpg","jpeg"];


function verifyInsertionFields(checktitle, checkimage, checkdescription){
    var title = checktitle.value;
    var imageName = checkimage.value;
    var description = checkdescription.value;

    if (title == ""){
        alert("A title is required!");
        return;
    } else {
        publishflag = true;
    }

    if(imageName == ''){
        alert("Please select an image first!");
        publishflag = false;
        return;
    } else{
        var name = imageName.toString().toLowerCase();
        // console.log(name);
        var arrayname = name.split('.');
        // console.log(arrayname);
        var fileType = arrayname[1].toString().toLowerCase();
        for(var i = 0; i < extentions.length; i++){
            if(!(extentions.includes(fileType))){
                alert("Invalid Image!");
                publishflag = false;
                break;
            }
        }
    }

    if(!(description == '') && (publishflag)){
        document.getElementById('uploadStatus').checked = true;
        document.getElementById('uploadStatus').value = "1";
        document.getElementById('upload').value = "1";
    }else{
        alert("Please input some description!");
    }

}
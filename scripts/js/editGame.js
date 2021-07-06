var imageName;
var publishflag = false;
var extentions = ["gif","png","jpg","jpeg"];
var gameExtentions = ["zip", "7z", "rar", "iso", "tar", "exe"];

function delgame(){
    document.getElementById('uploadStatus').checked = true;
    document.getElementById('uploadStatus').value = "1";
    document.getElementById('upload').value = "1";
}

function verifyInsertionFields(checktitle, checkcategory, checkimage, checkdescription, checkgame){
    var title = checktitle.value;
    var category = checkcategory.value;
    var game = checkgame.value;
    var imageName = checkimage.value;
    var description = checkdescription.value;

    if (title == ""){
        alert("A title is required!");
        return;
    } else {
        publishflag = true;
    }

    if(category == ''){
        alert("Please define a category first!");
        return;
    }else{
        publishflag = true;
    }

    if(imageName == ''){
        alert("No image was selected to update!");
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

    if(game == ''){
        alert("No game file is selected to update!");
    } else{
        var game_name = game.toString().toLowerCase();
        // console.log(name);
        var arrayname = game_name.split('.');
        // console.log(arrayname);
        var fileType = arrayname[1].toString().toLowerCase();
        for(var i = 0; i < gameExtentions.length; i++){
            if(!(gameExtentions.includes(fileType))){
                alert("Invalid Game File!");
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
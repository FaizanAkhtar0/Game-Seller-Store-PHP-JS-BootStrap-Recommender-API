var imageName;
var publishflag = false;
var extentions = ["gif","png","jpg","jpeg"];  //Image Extentions
var gameExtentions = ["zip", "7z", "rar", "iso", "tar", "exe"];


function verifyInsertionFields(checktitle, checkcategory, checkGame, checkimage, checkdescription, checkgameprice){
    var title = checktitle.value;
    var category = checkcategory.value;
    var price = checkgameprice.value;
    var game = checkGame.value;
    var imageName = checkimage.value;
    var description = checkdescription.value;

    if (title == ""){
        alert("A title is required!");
        return;
    } else {
        publishflag = true;
    }

    if (category == ""){
        alert("You must define a category first!");
        return;
    } else {
        publishflag = true;
    }

    if (price == ""){
        alert("You must enter the price first!");
        return;
    }else{
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

    if(game == ''){
        alert("Please select a game file to upload, first!");
        publishflag = false;
        return;
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
        console.log("uploadStatus: " +  document.getElementById('uploadStatus').value);
    }else{
        alert("Please input some description!");
    }

}
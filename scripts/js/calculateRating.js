var rating = "";

function starmark(item) {
    var count = item.id[0];
    // console.log("Count: " + count);
    rating = count;
    // console.log("Rating: " + rating);
    var subid = item.id.substring(1);
    // console.log("SubID: " + subid);
    for (var i = 0; i < 5; i++) {
        if (i < count) {
            // console.log("FullID: " + " i'" + (i + 1) + "' subID: " + subid);
            document.getElementById((i + 1) + subid).style.color = "lime";
        } else {
            document.getElementById((i + 1) + subid).style.color = "gray";
        }
    }
}

function showRating() {
    document.getElementById('ratedValue').value = rating;
    return rating;
}

function validateRating(selectedGame, userComments){
    document.getElementById('upload').value = "";
    document.getElementById("uploadStatus").checked = false;
    var gameID = selectedGame.value;
    var comments = userComments.value;

    if (gameID == ''){
        alert("Please select a game First!");
        return;
    } else if (comments == ''){
        alert("Please leave a review!");
        return;
    }

    if (showRating() == ''){
        alert("Please select stars!");
        return;
    }else{
        document.getElementById('upload').value = "1";
        document.getElementById("uploadStatus").checked = true;
        console.log(document.getElementById('upload').value);
    }


}
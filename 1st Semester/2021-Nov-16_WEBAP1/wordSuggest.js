$(start);

function start(){
    $("#myReading").on("keyup",inputHasChanged);
}

function inputHasChanged(){
    // alert("you will be pressented with some suggestions");
    $("#suggestions").load("suggestWord.php?startChars="+$("#myReading").val());  
}
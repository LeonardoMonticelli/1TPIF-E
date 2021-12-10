$(start);

function start(){
    $("#count").on("click",countLetters);
}

function countLetters(){
    let inputVal = $("#word").val();
    $("#display").load("index.php?display="+inputVal);
    $("#display").append(inputVal);
}
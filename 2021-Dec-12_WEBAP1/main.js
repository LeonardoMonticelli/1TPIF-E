$(start);

function start(){
    $("#count").on("click",countLetters);
}

function countLetters(){
    let inputVal = $("#input").val();
    $("#output").load("letterCount.php?word"+inputVal);
}
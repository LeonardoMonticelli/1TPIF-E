$(start);

function start(){
    $("#First").keyup(keyWasPressed);
}

function keyWasPressed(){
    let currentFirstInputValue = $("#First").val();
    $("#Second")
}
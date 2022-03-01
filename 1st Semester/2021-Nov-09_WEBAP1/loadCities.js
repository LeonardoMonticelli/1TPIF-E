$(start);

function start() {
    $("#cities").load("citySelect.php?"+"Country="+$("#Country").val());
    $("#Country").on("change",countryHasChanged);
}

function countryHasChanged(){
    $("#cities").html("");
    $("#cities").load("citySelect.php?"+"Country="+$("#Country").val())
}
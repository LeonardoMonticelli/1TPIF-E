$(start);

function start(){
    $("#giveDucks").on("click",callDucks);
}

function callDucks() { 
    // alert("The ducks come from the trucks");
    let myInputVal = $("#duck").val();
    let newDiv =$("<div></div>");
    $("#output").load(`dataProvider.php?duck=${myInputVal}`);
    $("#birds").append(newDiv);
}
$(start);

function start(){
    $("#giveBirds").on("click",callDucks);
}

function callDucks() { 
    // alert("The ducks come from the trucks");
    let myInputVal = $("#numberOfBirds").val();
    let newDiv =$("<div></div>");
    if($("#birds").val()=="duck"){
        newDiv.load(`dataProvider.php?duck=${myInputVal}`);
    } else if ($("#birds").val()=="chicken"){
        newDiv.load(`dataProvider.php?chicken=${myInputVal}`);
    }
    // $("#output").load(`dataProvider.php?chicken=${myInputVal}`);
    $("#output").append(newDiv);
}
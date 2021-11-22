$(start);

function start(){
    $('button').on("click",buttonClicked);

    $("table").load("carList.php");
}

function buttonClicked(){
    // alert("you have set the maximum price to "+$("#maxPrice").val());
    $("table").load("carList.php?givenPrice="+$("#givenPrice").val());
}
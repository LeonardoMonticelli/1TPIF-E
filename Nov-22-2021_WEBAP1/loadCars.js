$(start);

function start(){
    $('button').on("click",buttonClicked);

    $("table").load("carList.php");
}

function buttonClicked(){
    // alert("you have set the maximum price to "+$("#maxPrice").val());
    //do the if statement over here
    
    if($("#choiceOfPrice").val()==0){
        $("table").load("carList.php?maxPrice="+$("#givenPrice").val());

    } else {
        $("table").load("carList.php?minPrice="+$("#givenPrice").val());
    }
    
}
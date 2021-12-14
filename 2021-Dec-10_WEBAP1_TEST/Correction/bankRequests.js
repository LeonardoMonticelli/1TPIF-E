$(start);

function start(){
    $('#Login').on("click",userLoggedIn);
}

function userLoggedIn(){
    //display the account balance
    $("#AmountInAccount").load("backend.php?UserBalance="+$("#User").val());
    //create the next inputs and buttons
    let createActions =$("<input id='amount'><button id='deposit'>Deposit Amount</button><button id='withdraw'>Withdraw Amount</button>")
    //create an input to put a number value in it, to deposit or withdraw
    $("#NextActions").html("");
    $("#NextActions").append(createActions);
    $('#deposit').on("click", depositAmount);
    $('#withdraw').on("click", withdrawAmount);
}

function depositAmount(){
    $("#ResultOperation").load("backend.php?UserDeposit="+$("#User").val()+"&Amount="+$("#amount").val(),userLoggedIn);
}

function withdrawAmount(){
    $("#ResultOperation").load("backend.php?UserWithdraw="+$("#User").val()+"&Amount="+$("#amount").val(),userLoggedIn);
}
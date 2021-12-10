$(start);

function start(){
    $('Login').on("click",userLoggedIn);
}

function userLoggedIn(){
    //create the next inputs and buttons
    let createActions =$("<input id='amount'><button id='deposit'>Deposit Amount</button><button id='withdraw'>Withdraw Amount</button>")
    //display the account balance
    $("#AmountInAccount").load("backend.php?User="+$("#User").val());
    //create an input to put a number value in it, to deposit or withdraw
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
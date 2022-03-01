$(start);

function start(){
    $('Login').on("click",userLoggedIn);

    $("#AmountInAccount").load("backend.php");
}

function userLoggedIn(){
    let userVal = $("#User").val(); 
    //create the next inputs and buttons
    let createActions =$("<input id='amount'><button id='deposit'>Deposit Amount</button><button id='withdraw'>Withdraw Amount</button>")
    //display the account balance
    $("#AmountInAccount").load(`backend.php?User=${userVal}`);
    //create an input to put a number value in it, to deposit or withdraw
    $("#NextActions").append(createActions);

    $('#deposit').on("click", depositAmount);
    $('#withdraw').on("click", withdrawAmount);
}

function depositAmount(){
    let depositMessage = "We have deposited "+$('#amount').value+" into your account";
    $("#deposit").append(depositMessage);
}

function withdrawAmount(){
    let withdrawMessage = "We have withdrawn "+$('#amount').value+" from your account";
    $("#withdraw").append(withdrawMessage);
}
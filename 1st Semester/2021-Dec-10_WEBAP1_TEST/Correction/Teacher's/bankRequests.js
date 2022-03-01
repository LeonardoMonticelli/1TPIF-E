$(start);

function start()
{
    $("#Login").on("click",Login);
}

function Login()
{
    $("#AmountInAccount").load("bankServer.php?UserBalance="+$("#User").val());
    let amount = $("<input id='amount'>");
    let DepositBtn = $("<button>Deposit amount</button>");
    let WidthdrawBtn = $("<button>Widthdraw amount</button>");
    $("#NextActions").html("");
    $("#NextActions").append(amount);
    $("#NextActions").append(DepositBtn);
    $("#NextActions").append(WidthdrawBtn);
    WidthdrawBtn.on("click",withDraw);
    DepositBtn.on("click",deposit);
}

function withDraw()
{
    let UserName = $("#User").val();
    let amount = $("#amount").val();
    $("#ResultOperation").load(`bankServer.php?UserWithdraw=${UserName}&amount=${amount}`,Login);
}

function deposit()
{
    $("#ResultOperation").load("bankServer.php?UserDeposit="+$("#User").val()+"&amount="+$("#amount").val(),Login);
}


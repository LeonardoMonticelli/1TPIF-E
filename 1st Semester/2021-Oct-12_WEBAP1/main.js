$(start);

function start(){
    $("button").html("click me");
    $("button").on("click",fnc); //the same as addEventListener
    $("select").on("change",fnc); //if you use one instead of on, the code will react only once
    function fnc(){
        alert("thou hast clicketh this page");
    }
}
window.addEventListener("load", start);

function start(){
    document.getElementById("btnFlag").addEventListener("click", change);
}

function change(){
    if(document.getElementById("btnFlag").innerHTML=="Enable"){
        document.getElementById("btnFlag").innerHTML="Disable";
    }
     else if(document.getElementById("btnFlag").innerHTML=="Disable") {
        document.getElementById("btnFlag").innerHTML="Enable";
    }
}
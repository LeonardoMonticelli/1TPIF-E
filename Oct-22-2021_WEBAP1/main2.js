$(start);

function start(){
    dogbtn = $("<button>add dog</button>");
    dogbtn.attr("id", "dogID");
    $("body").append(dogbtn);
    dogbtn.on("click", dog);

    catbtn = $("<button>add cat</button>");
    catbtn.attr("id", "dogID");
    $("body").append(catbtn);
    catbtn.on("click", cat);
}

function cat(){
    img=$("<img>")
    img.attr("src","cat.png");
    $("body").append(img);
}

function dog(){
    img=$("<img>")
    img.attr("src","dog.jpg");
    $("body").append(img);
}
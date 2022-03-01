$(start);

function start(){
    // $("button").on('click',insertPage);
    let myList = $("<ul></ul>");
    let newListItem = $("<li></li>");
    newListItem.append("Dacia");
    myList.append(newListItem);
    newListItem= $("<li></li>");
    newListItem.append("Volvo");
    myList.append(newListItem);

    $("body").append(myList);
}

// function insertPage() { 
//     $("p").load("index2.html #2");
//  }
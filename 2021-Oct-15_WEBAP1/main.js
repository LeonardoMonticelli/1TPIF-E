$(start);

function start(){
    p = $('<p></p>');
    $('div').append(p);
    $('p').html('This is a paragraph');

    button1 = $('<button>add paragraph</button>');
    button1.on("click",insert)
    button2 = $('<button>remove paragraph</button>');
    button1.on("click",remove)
    $('body').append(button1);
    $('body').append(button2);
    $('button:nth-child(1)').on('click',click1);
    $('button:nth-child(2)').on('click',click2);
}

function insert(){
    para= $('<p>new para</p>');
    $('body').append(para);
}

function remove(){
    para= $('');
    $('body').append(para);
}
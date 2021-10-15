$(start);

function start(){
    p = $('<p></p>');
    $('div').append(p);
    $('p').html('This is a paragraph');

    b = $('<button></button>');
    $('body').append(b);


    c = $('<button></button>');
    $('body').append(c);
    $('button:nth-child(2)').html('remove me');
    $('button:nth-child(2)').on('click',remove);
}

function insert(){
    para= $('<p>new para</p>');
    $('body').append(para);
}

function remove(){
    para= $('');
    $('body').append(para);
}
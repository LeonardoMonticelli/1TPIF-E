$(start);

function start(){
    $("p").each(
        function() {
            var p1 = $("#pTag").html();
            $("#secondPTag").html(p1);
            $("p:nth-child(3)").html(p1);
        });
}
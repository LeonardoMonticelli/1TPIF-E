<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Ex1</title>
        <style>
            .box {
                width: 50px;
                height: 50px;
                margin: 5px;
                display: inline-block;
            }
            .blueBox {
                background-color: blue;
            }
            .redBox {
                background-color: red;
            }
            .yellowBox {
                background-color: yellow;
            }
        </style>
    </head>
    <body>
    <?php
        $handler= fopen("input.txt","r");
        while($line=fgets($handler)){
            print("<div>");
            $trimmed=trim($line);
            $delimited=explode(",",$line);
                if(sizeof($delimited)!=5){
                    echo("Cannot parse this row");
                } else {
                    $sum=$delimited[2]+$delimited[3]+$delimited[4];
                    
                    if($sum>$delimited[0]){
                        echo("MAX LIMIT reached");
                    } else {
                        for($a=0;$a<$sum;$a++){
                            print("<div class='box ".$delimited[1]."'></div>");
                        }
                    }
                }
            print("</div>");
        };
    ?>
        <!-- <div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
            <div class="box redBox"></div>
        </div>
        <div>MAX LIMIT reached</div>
        <div>
            <div class="box blueBox"></div>
            <div class="box blueBox"></div>
            <div class="box blueBox"></div>
        </div>
        <div>
            <div class="box blueBox"></div>
            <div class="box blueBox"></div>
            <div class="box blueBox"></div>
        </div>
        <div>Cannot parse this row</div>
        <div>
            <div class="box yellowBox"></div>
            <div class="box yellowBox"></div>
            <div class="box yellowBox"></div>
            <div class="box yellowBox"></div>
            <div class="box yellowBox"></div>
            <div class="box yellowBox"></div>
        </div>
        <div>Cannot parse this row</div>
        <div><div class="box redBox"></div></div>
    </body> -->
</html>

<form method="post">
    <input name="n">
    <input type="submit" value="Calculate" name="submit">
</form>
<?php
    if(isset($_POST["submit"])){
        $n=$_POST['n'];
        function calculate($n){
            for($i=1;$i<=$n;$i++){
                $result=$i*($i+1);
                echo $i . '*' . ($i+1) . "=" . $result . "<br/>";
            }
            echo($result);
        }
        calculate($n);
    } else {
        echo("error");
    }
?>
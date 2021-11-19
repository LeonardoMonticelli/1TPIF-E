<form action="" method="post">
    <input type="submit" value="delete" name="delete">
</form>
<?php
    if(isset($_POST['delete'])){
        $fileHandler = fopen("data\\shopData.txt", "r");
        $newArray=[];
        $limit=3;
        function deletusFetus(){
            while($line=fgets($fileHandler)){
                $product = explode("|", $line);
                if(sizeof($product)==$limit){
                array_push($newArray,$line);}
                else {
                    print("line erased<br>");
                }
            }
            $newArray=implode('|',$newArray);
            fwrite($fileHandler, $newArray);
            print("done!");
            fclose($fileHandler);
        }
        deletusFetus();
    } else {
        die();
        print("error");
    }
?>
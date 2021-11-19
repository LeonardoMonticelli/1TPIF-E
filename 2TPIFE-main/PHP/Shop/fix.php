<button onclick='window.location = "fix.php?deleteCrap"'>MEMEMEME</button>
<?php
if(isset($_GET["deleteCrap"])) deleteCrap();
function deleteCrap(){
    $fileHandler = fopen("data\\shopData.txt","r");
    $limit = 4;
    $newArray=[];
    if($fileHandler){
        while($line=fgets($fileHandler)){
            $product = explode("|", $line);
            if(sizeof($product)!= $limit) continue;
            array_push($newArray, $line);
        }
        fclose($fileHandler);
        var_dump($newArray);
        file_put_contents("data\\shopData.txt", implode("", $newArray));
    } else {
        die("error");
    }
}

?>
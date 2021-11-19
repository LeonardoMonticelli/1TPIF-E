<?php
if(isset($_POST["productToDelete"])){
    print "You are about to delete the product number ".$_POST["productToDelete"];
    if($_SESSION["isUserLoggedIn"] && ifUserIsAdmin($_SESSION["currentUser"])){
            $fileData=[];
            $fileHandler= fopen("data\\shopData.txt", "r");
            $currentLine = 0;
            while($line=fgets($fileHandler)){
                if($currentLine!=$_POST["productToDelete"]){
                    array_push($fileData,$line);
                    ++$currentLine;
            }
            fclose($fileHandler);
        
        $fileHandler = fopen("data\\shopData.txt","r");
        foreach($fileData as $product){
            fputs($fileHandler,$product);
        }
        fclose($fileHandler);
    }
    } 
    else 
    {
        print "Nice try... you're not hacking me.";
    }
}
?>
<div id="bigsqua">
    <div class="prod">
        <?php  
            $fileHandler = fopen("data\\shopData.txt","r");
            while($line=fgets($fileHandler)){
                $product = explode("|", $line);
        ?>
                <div class="box">
                <img class="product_image" src="<?=$product[0];?>" style="width:20em;height:15em">
                <div class="bellow">
                    <div class="tag name"><?=$product[1];?></div>
                    <div class="tag price">Price: <?=$product[2];?></div>
                    <div class="tag desc">Description: <?=$product[3];?></div>
                </div>
                <?php
                    if($_SESSION["isUserLoggedIn"] && ifUserIsAdmin($_SESSION["currentUser"])){
                        ?>
                            <form action="post">
                                <input name="productToDelete" value="<?=$currentLine?>">
                                <input type="submit" name="Delete" value="Delete this product">
                            </form>
                        <?php
                    }
                ?>
                </div>
            <?php
                $currentLine++;
                }
                fclose($fileHandler);
            ?>
    </div>
        <div>
            <?php       
                // if (isset($_POST['field1']) && isset($_POST['field2']) && isset($_POST['field3']) && isset($_POST['field4'])) {
                // $fileHandler = fopen("shopData.txt","a+");
                // $string = $_POST['field1'].' | '.$_POST['field2'].' | '.$_POST['field3'].' | '.$_POST['field4'];
                // fwrite($fileHandler,$string);
                // fclose($fileHandler);}
            ?>
            <!-- <button type="submit" class="btn btn-primary">SAVE</button> -->
        </div>
    </form>
</div>
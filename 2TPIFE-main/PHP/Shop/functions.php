<?php 
    function addNavLink($pageLink,$pageText){
        $explodedLink=explode("/",$_SERVER["REQUEST_URI"]);
        $sizeExpLinkArray = sizeof($explodedLink);
        if($pageLink == $explodedLink[$sizeExpLinkArray-1])
        {
            ?>
            <a class="activeLink" href="<?=$pageLink?>">
                <?=$pageText?>
            </a>
            <?php
        }
        else {  
            ?>
            <a class="inactiveLink" href="<?=$pageLink?>">
            <?=$pageText?>
            </a>
            <?php
        }
    }
    function ifUserIsAdmin($who){
        // this function will check if $who is admin or not
        //it will return:
        // TRUE if the is admin
        $fileHandler = fopen("data\\admins.txt", "r");
        while($line=fgets($fileHandler)){
            $oneAdmin = trim($line);
            if($who==$oneAdmin){
                return true;
            }
        }
        return false;
    }
?>
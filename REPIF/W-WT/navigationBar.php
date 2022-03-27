<?php //head
    $pageTitle ="SmartBox Management";
    include_once "sessionCheck.php";
?>
<div class="navigation bg-dark p-2">
        <?php
            function addNavLink($pageLink,$pageText){
                $explodedLink=explode("/",$_SERVER["REQUEST_URI"]);
                $sizeExpLinkArray = sizeof($explodedLink);
                if($pageLink == $explodedLink[$sizeExpLinkArray-1])
                {
                    ?>
                    <a class="text-decoration-none text-muted p-1" href="<?=$pageLink?>">
                        <?=$pageText?>
                    </a>
                    <?php
                }
                else {  
                    ?>
                    <a class="text-decoration-none text-light p-1" href="<?=$pageLink?>">
                    <?=$pageText?>
                    </a>
                    <?php
                }
            }
                $navigationLinks=["index.php"=>"Home","sbManagement.php"=>"SmartBox Management","pins.php"=>"Pin Management","administration.php"=>"Administration", "script.php"=>"Scripts", "logout.php"=>"Log Out"];
                foreach ($navigationLinks as $key => $value) {
                        addNavLink($key,$value);
                }
        ?>
</div>
<br>
<div class="navigation">
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
                $navigationLinks=["index.php"=>"Home","sbManagement.php"=>"SmartBox Management","administration.php"=>"Administration"];
                foreach ($navigationLinks as $key => $value) {
                        addNavLink($key,$value);
                }
        ?>
</div>
<ul class="nav bg-dark">
    <?php
        function addNavLink($pageLink,$pageText){
            $explodedLink=explode("/",$_SERVER["REQUEST_URI"]);
            $sizeExpLinkArray = sizeof($explodedLink);
            if($pageLink == $explodedLink[$sizeExpLinkArray-1])
            {
                ?>

                <li class="nav-item">
                    <a class="nav-link disabled" aria-current="page" href="<?=$pageLink?>"><?=$pageText?></a> <!--Current page-->
                </li>

                <?php
            }
            else {  
                ?>

                <li class="nav-item">
                    <a class="nav-link text-light" aria-current="page" href="<?=$pageLink?>"><?=$pageText?></a> <!--Other pages-->
                </li>

                <?php
            }
        }
            $navigationLinks=["index.php"=>"Home", "sbManagement.php"=>"SmartBox Management", "pinManagement.php"=>"Pin Management", "script.php"=>"Scripts", "userManagement.php"=>"Users", "userConfiguration.php"=>"Configuration"];
            foreach ($navigationLinks as $key => $value) {
                    addNavLink($key,$value);
            }
    ?>
    <div class="float-end">
        <li class="nav-item">
            <a class="nav-link active text-light" aria-current="page" href="logout.php">Log out</a>
        </li>
    </div>
</ul>

<br>
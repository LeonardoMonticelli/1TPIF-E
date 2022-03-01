<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Tasks revision</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href=''>
    <script src=''></script>
</head>
<body>
    <?php
        $items = ["Fruits","Vegetables","Meat","Carrots","Peas","Beans","Tomatoes"];
        $indices =[1,-1,0,3,4,5,6,2,7,0];
        $newIndices=[];
        for($a=0;$a<sizeof($indices);$a++){
            if($indices[$a]>=0 && $indices[$a]<sizeof($items)){
                array_push($newIndices,$indices[$a]);
            }
        }
        ?>
        <select><?php
        for($b=0;$b<sizeof($newIndices);$b++){
            ?>
            <option value="<?=$newIndices[$b]?>"><?=$items[$newIndices[$b]]?>
            <?php
        }
        ?>        
        </select><?php
        for($c=0;$c<sizeof($newIndices);$c++){?>
            <ul>
                <li><?=$items[$newIndices[$c]]?></li>
            </ul>
            <?php
        }
        ?>
</body>
</html>
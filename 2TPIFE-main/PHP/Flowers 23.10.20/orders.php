<?php //retrieving text file into a new html
        $handle = fopen("data.txt", "r");
        if($handle) {//if it is true
            $a=0;
            while (($line =fgets($handle))){//if == true, it gives one line from the txt file
                echo ++$a.". ".$line."<br>";
            }
            fclose($handle);
        }
        else {
            echo "data could not be retrieved";
        }
?>
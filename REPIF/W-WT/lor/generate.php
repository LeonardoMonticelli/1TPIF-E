<?php

function generateConfig($hostname) { // Generate config file
    require("db.php"); // Database connection
    if(!isset($hostname)) { // If hostname is not set
        echo "No HostName specified"; // Error
        exit; // Exit
    }

    $groups = $conn->prepare("SELECT * FROM `group` WHERE `HostName` = :HostName"); // Prepare query
    $groups->bindParam(":HostName", $hostname); // Bind hostname
    $groups->execute(); // Execute query
    $groups = $groups->fetchAll(); // Fetch all results

    $groupList = array(); // Create array for groups
    foreach($groups as $group) { // Loop through groups
        $gname = "group_" . $group["GroupNo"]; // Create group name
        $groupScripts = $conn->prepare("SELECT * FROM `use` WHERE `GroupNo` = :GroupNo"); // Prepare query
        $groupScripts->bindParam(":GroupNo", $group["GroupNo"]); // Bind group number
        $groupScripts->execute(); // Execute query
        $groupScripts = $groupScripts->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
        $newGroupScripts = []; // Create array for scripts
        foreach($groupScripts as $script) { // Loop through scripts
            array_push($newGroupScripts, $script["ScriptName"]); // Add script to array
        }

        $groupLeds = $conn->prepare("SELECT * FROM `group_leds` WHERE `GroupNo` = :GroupNo"); // Prepare query
        $groupLeds->bindParam(":GroupNo", $group["GroupNo"]); // Bind group number
        $groupLeds->execute(); // Execute query
        $groupLeds = $groupLeds->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
        $newGroupLeds = []; // Create array for leds
        foreach($groupLeds as $gled) { // Loop through leds
            array_push($newGroupLeds, [intval($gled["pin_number"]), $gled["pin_action"], 5]); // Add led to array
        }

        $motorInfo = $conn->prepare("SELECT * FROM `group_motor` WHERE `GroupNo` = :GroupNo"); // Prepare query
        $motorInfo->bindParam(":GroupNo", $group["GroupNo"]); // Bind group number
        $motorInfo->execute(); // Execute query
        if($motorInfo->rowCount() > 0) { // If there is a motor
            $groupList[$gname] = array( // Add group to array
                "scripts" => $newGroupScripts, // Add scripts to array
                "leds" => $newGroupLeds, // Add leds to array
                "motor" => $motorInfo->fetch(PDO::FETCH_ASSOC)["group_action"] // Add motor to array
            );
        } else { // If there is no motor
            $groupList[$gname] = array( // Add group to array
                "scripts" => $newGroupScripts, // Add scripts to array
                "leds" => $newGroupLeds // Add leds to array
            );
        }
    }

    $inputs = $conn->prepare("SELECT * FROM `group_switches` gs JOIN `group` g ON gs.GroupNo = g.GroupNo WHERE g.`HostName` = :HostName"); // Prepare query
    $inputs->bindParam(":HostName", $hostname); // Bind hostname
    $inputs->execute(); // Execute query
    $inputs = $inputs->fetchAll(); // Fetch all results
    $inputList = []; // Create array for inputs
    foreach($inputs as $input) { // Loop through inputs
        array_push($inputList, ["REMOVED", ["group_".$input["GroupNo"]], intval($input["pin_number"])]); // Add input to array
    }

    $employees= array( // Create array for employees
        'groups' => $groupList, // Add groups to array
        'inputs' => $inputList // Add inputs to array
    );

    //Convert the array into YAML content

    $data = yaml_emit($employees); // Convert array to YAML

    // Create file
    $myfile = fopen("confs/" . $hostname  . ".yml", "w+") or die("Unable to open file!"); // Open file  or die
    fwrite($myfile, $data); // Write data to file 
    fclose($myfile); // Close file

    //Upload to server

    $connection = ssh2_connect($hostname, 22); // Connect to server
    ssh2_auth_password($connection, 'webscp', 'mno'); // Authenticate

    ssh2_scp_send($connection, "confs/" . $hostname . ".yml", '/home/pi/pif2122/config.yml', 0777); // Upload file
    echo "Config Generated"; // Success
}
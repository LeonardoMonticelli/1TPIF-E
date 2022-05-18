<?php
include_once "databaseConnect.php";

function createGroupConf($connection, $input) {
    $groups = $connection->prepare("
        SELECT `groups`.GroupName, `groups`.GroupNo, concern.PinNo FROM `groups`, concern
        WHERE concern.GroupNo = `groups`.GroupNo AND `groups`.HostName = ?
    ");

    $groups->bind_param('s', $input["HostName"]);

    $groups->execute();

    $groupsresult = $groups->get_result();

    $groupsdata = $groupsresult->fetch_all(MYSQLI_ASSOC);

    $scripts = $connection->prepare("
        SELECT `use`.GroupNo, `use`.ScriptName, scripts.Path FROM `use`, scripts, groups
        WHERE scripts.ScriptName = `use`.ScriptName AND `groups`.HostName = ?
        GROUP BY
            `use`.GroupNo, `use`.ScriptName
        HAVING 
            COUNT(*) > 1
    ");

    $scripts->bind_param('s', $input["HostName"]);

    $scripts->execute();

    $scriptsresult = $scripts->get_result();

    $scriptsdata = $scriptsresult->fetch_all(MYSQLI_ASSOC);

    $content = array();

    foreach($groupsdata as $obj) {
        if(!array_key_exists($obj["GroupName"], $content)) $content[$obj["GroupName"]] = [];
        array_push($content[$obj["GroupName"]], $obj["PinNo"]);
    }

    $fp = fopen("config/gl.txt", "wb");

    foreach($content as $i => $group) {
        $line = "".$i."=".implode(',', $group)."\n";
        fwrite($fp, $line);
    }

    foreach($scriptsdata as $script) {
        $line = "".$script["ScriptName"]."=\"".$script["Path"]."\"\n";
        fwrite($fp, $line);
    }

    fclose($fp);
}

function createExecConf($connection, $input) {
    $stmt= $connection->prepare("
        SELECT * FROM switchexecute, pins, groups
        WHERE pins.PinNo = switchexecute.PinNo AND `groups`.GroupNo = switchexecute.GroupNo 
        AND switchexecute.HostName = ?
    ");

    $stmt->bind_param('s', $input["HostName"]);

    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $fp = fopen("config/tefg.txt", "wb");

    foreach($data as $exec) {
        $duration = $exec["WaitingDuration"] ? ", ".$exec["WaitingDuration"] : '';
        $line = "".$exec["Designation"].", ".$exec["EventCode"]."=".$exec["TargetFunctionCode"].", ".$exec["GroupName"].":".$exec["TargetFunctionCode"]."".$duration."\n";
        fwrite($fp, $line);
    }

    fclose($fp);
}

function sendConf($connection, $input) {
    createGroupConf($connection, $input);
    createExecConf($connection, $input);

    // return; // leave this activated when not connected to the rpi

    $sshconnection = ssh2_connect('192.168.6.235', 22); // ip address of the rpi

    ssh2_auth_password($sshconnection, 'pi', '123'); // the password is the last field

    ssh2_scp_send($sshconnection,"config/gl.txt", '/home/pi/pif2122/data/gl.txt', 0644);
    ssh2_scp_send($sshconnection,"config/tefg.txt", '/home/pi/pif2122/data/tefg.txt', 0644);
}

if(isset($_GET["HostName"])){
    sendConf($connection, $_GET);
    header("location: sbManagement.php");
}
?>
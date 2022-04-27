<?php
include_once "databaseConnect.php";

function createGroupConf($connection, $input) {
    $groups = $connection->prepare("
        SELECT `groups`.GroupName, `groups`.GroupNo, concern.PinNo FROM `groups`
        INNER JOIN concern ON concern.GroupNo = `groups`.GroupNo
        WHERE `groups`.HostName = ?
    ");

    $scripts = $connection->prepare("
        SELECT `use`.GroupNo, `use`.ScriptName, scripts.Path FROM `use`
        INNER JOIN scripts ON scripts.ScriptName = `use`.ScriptName
        INNER JOIN `groups` ON `groups`.HostName = ?
    ");

    $groups->bind_param('s', $input["HostName"]);

    $groups->execute();

    $groupsresult = $groups->get_result();

    $groupsdata = $groupsresult->fetch_all(MYSQLI_ASSOC);

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
        SELECT * FROM switchexecute
        INNER JOIN pins ON pins.PinNo = switchexecute.PinNo
        INNER JOIN `groups` ON `groups`.GroupNo = switchexecute.GroupNo
        WHERE switchexecute.HostName = ? AND pins.HostName = switchexecute.HostName
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

    return; // leave this activated when not connected to the rpi

    $sshconnection = ssh2_connect('192.168.6.61', 22); // change the ip address

    ssh2_auth_password($sshconnection, 'pi', 'cgo'); //the ip is from the rpi, the password is the last field

    ssh2_scp_send($sshconnection,"config/gl.txt", '/home/pi/pif2122/data/gl.txt', 0644);
    ssh2_scp_send($sshconnection,"config/tefg.txt", '/home/pi/pif2122/data/tefg.txt', 0644);
}

if(isset($_GET["HostName"])){
    sendConf($connection, $_GET);
    header("location: sbManagement.php");
}
?>
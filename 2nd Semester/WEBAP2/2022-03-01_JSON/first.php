<?php

$genericObject = new stdClass();
$genericObject->version = "0.2.0";
$genericObject->configurations=[];

$myFirstConfig=new stdClass();
$myFirstConfig->type="pwa-chrome";
$myFirstConfig->request="launch";
$myFirstConfig->name="Launch Chrome against localhost";
$myFirstConfig->file="{file}";
$myFirstConfig->webRoot="{workspaceFolder}";

array_push($genericObject->configurations,$myFirstConfig);

echo json_encode($genericObject);
?>
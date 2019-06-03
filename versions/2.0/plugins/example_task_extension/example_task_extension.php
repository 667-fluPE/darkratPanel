<?php

$pluginName = "example_task_extension";

$actual_host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "http" : "http") . "://$_SERVER[HTTP_HOST]";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;

/*
 * Idea TODO
 */
$GLOBALS["task_configuration"]["example_task"] = array(
    "name" => "Example Plugin Task",
    "command" => "runplugin",
    "value" => "http://".$_SERVER["HTTP_HOST"]."/versions/".$GLOBALS["loadedVersion"]."/plugins/".$pluginName."/dll/example.dll;DisplayHelloFromDLL;exampleparameter",
);



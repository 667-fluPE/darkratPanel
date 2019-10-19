<?php


$pluginName = "reverse_socks";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;
require_once ("Controller/reverse_socks.class.php");

register_navigation_tab($pluginName,get_plugin_include_dir($pluginName)."assets/nav/about.svg");

$router->all('/reverse_socks', 'reverse_socks@dashboard');
$router->all('/reverse_socks_controll', 'reverse_socks@reverse_socks_controll');

$host = "http://".$_SERVER["HTTP_HOST"];

$GLOBALS["task_configuration"][$pluginName] = array(
    "name" => "Start Reveres Socks Server",
    "command" => "runplugin",
    "value" => $host."/versions/".$GLOBALS["loadedVersion"]."/plugins/".$pluginName."/dll/socks.dll;socks;127.0.0.1"
);



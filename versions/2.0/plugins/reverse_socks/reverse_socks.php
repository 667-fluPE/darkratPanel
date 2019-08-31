<?php


$pluginName = "reverse_socks";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;
require_once ("Controller/reverse_socks.class.php");

register_navigation_tab($pluginName,get_plugin_include_dir($pluginName)."assets/nav/about.svg");

$router->all('/reverse_socks', 'reverse_socks@dashboard');
$router->all('/reverse_socks_controll', 'reverse_socks@reverse_socks_controll');




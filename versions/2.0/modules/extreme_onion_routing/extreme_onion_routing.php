

<?php
//https://github.com/DonnchaC/oniongateway

require "Controller/Backend.class.php";
require "Controller/Ajax.class.php";

$GLOBALS["foundPlugins"]["extreme_onion_routing"]["plugindir"] = __DIR__;


$GLOBALS["tpl"]->assign("ajaxDir", "/extreme_onion_routing/ajax/");

register_navigation_tab("extreme_onion_routing",get_plugin_include_dir("extreme_onion_routing")."assets/nav/logs.svg");

$router->all('/extreme_onion_routing/', 'Backend@extreme_onion_routing');
$router->all('/extreme_onion_routing/gates', 'Backend@manage_gates');
$router->all('/extreme_onion_routing/routers', 'Backend@manage_routers');
$router->all('/extreme_onion_routing/ajax/(\w+)', 'Ajax@manage');
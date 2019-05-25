<?php

/*
 * Add your Controllers
 */
require __DIR__."/Controller/testplugin.class.php";
require __DIR__."/Controller/aboutConroller.class.php";


/*
 * Set Plugin dir in Globals
 */
$GLOBALS["foundPlugins"]["testplugin"]["plugindir"] = __DIR__;




/*
 * Override a Default Route
 */
$router->before('GET', '/dashboard', function() {
    header('location: /dashboard_testplugin');
    exit();
});
$router->all('/dashboard_testplugin', 'testplugin@dashboard');


/*
 * Add your Routs
 */
$router->all('/about', 'aboutConroller@about');

/*
 * Register a Navigation Tab
 */
register_navigation_tab("about",get_plugin_include_dir("testplugin")."assets/nav/about.svg");






?>
<?php

/*
 * Add your Controllers
 */
require __DIR__."/Controller/aboutConroller.class.php";


/*
 * Set Plugin dir in Globals
 */
$GLOBALS["foundPlugins"]["about"]["plugindir"] = __DIR__;



/*
 * Add your Routs
 */
$router->all('/about', 'aboutConroller@about');

/*
 * Register a Navigation Tab
 */
register_navigation_tab("about",get_plugin_include_dir("about")."assets/nav/about.svg");






?>
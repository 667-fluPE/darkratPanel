<?php

$pluginName = "custom_urls";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;


$GLOBALS["defaulRoutes"]["Main@login"] = "/lg";

register_settings_tab("Routes",false,get_plugin_base_dir($pluginName)."/template/settings/options.tpl");

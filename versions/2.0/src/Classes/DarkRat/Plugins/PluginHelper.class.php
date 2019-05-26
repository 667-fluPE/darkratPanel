<?php



function register_navigation_tab($name, $iconPath)
{
    $GLOBALS["navigation"][$name] = $iconPath;
}

function get_plugin_base_dir($pluginName)
{
    return $GLOBALS["foundPlugins"][$pluginName]["plugindir"];
}

function get_plugin_include_dir($pluginName)
{
    return $GLOBALS["foundPlugins"][$pluginName]["includeDir"];
}

function register_settings_tab($name, $bodyhtml, $includeDir = "")
{

    $GLOBALS["pluginSetting_Tabs"][] = array(
        "name" => $name,
        "body" => $bodyhtml,
        "includeDir" => $includeDir,
    );
}

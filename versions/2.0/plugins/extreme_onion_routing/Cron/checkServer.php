<?php


include( "../../../../../config.php");


$checkOffline = true;


$whereOffline = "";
if($checkOffline  == false){
    $whereOffline = " where description != 'offline' ";
}

/*
 *
 *          Check the Routing Servers
 */

$statement = $GLOBALS["pdo"]->prepare("SELECT * FROM extreme_routing_server ".$whereOffline);
$statement->execute(array());
while ($row = $statement->fetch()) {

    $connection = ssh2_connect($row["ip"], $row["port"]);
    ssh2_auth_password($connection,  $row["user_name"], $row["password"]);
    $stream = ssh2_exec($connection, 'whoami');
    stream_set_blocking($stream, true);
    $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);

    if(trim(stream_get_contents($stream_out)) == $row["user_name"]){
        $status = "online";
    }else{
        $status = "offline";
    }
    $statement = $pdo->prepare("UPDATE extreme_routing_server SET description = ? WHERE id = ?");
    $statement->execute(array($status, $row["id"]));

}

/*
 *
 *          Check the Domains
 */



$statement2 = $GLOBALS["pdo"]->prepare("SELECT * FROM extreme_routing_domains ".$whereOffline);
$statement2->execute(array());
while ($row2 = $statement2->fetch()) {
    //var_dump($row);
    $status = "suspended";

    $host = $row2["server_domain"];
    if($socket =@ fsockopen($host, 80, $errno, $errstr, 30)) {
        $status = 'online';
        fclose($socket);
    } else {
        $status = 'offline';
    }
    //curl_close($curlInit);

    $statement = $pdo->prepare("UPDATE extreme_routing_domains SET description = ? WHERE id = ?");
    $statement->execute(array($status, $row2["id"]));

}



//var_dump($routers);
<?php
use GeoIp2\Database\Reader;

class reverse_socks{

    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("reverse_socks") . "/template";
    }

    function check($host,$port)
    {
        $waitTimeoutInSeconds = 10;
        if($fp = @fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){
            fclose($fp);
            return true;
        } else {
            fclose($fp);
            return false;
        }
    }

    public function dashboard(){
        $GLOBALS["template"][1] = "dashboard";


        if(!empty($_GET["check"])){
            $sql = "SELECT * FROM reverse_socks WHERE `lastcheck` < (NOW() - INTERVAL 30 MINUTE)";
            foreach ($GLOBALS["pdo"]->query($sql) as $row) {

                if(!$this->check($row["ip"],$row["status"])){
                    $statement = $GLOBALS["pdo"]->prepare("DELETE FROM reverse_socks WHERE id = :id ");
                    $statement->execute(array('id' => $row["id"]));
                }else{
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE reverse_socks SET lastcheck = CURRENT_TIMESTAMP() WHERE id = ?");
                    $statement->execute(array($row["id"]));
                }
            }
        }

        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM reverse_socks ORDER BY lastcheck");
        $statement->execute(array());
        $all =array();
        while($row = $statement->fetch()) {
            $all[] = $row;
        }
        $GLOBALS["tpl"]->assign("all", $all);
    }


    public function reverse_socks_controll(){
        $sql = "SELECT * FROM reverse_socks WHERE `lastcheck` < (NOW() - INTERVAL 10 MINUTE) LIMIT 10";
        foreach ($GLOBALS["pdo"]->query($sql) as $row) {

            if(!$this->check($row["ip"],$row["status"])){
                $statement = $GLOBALS["pdo"]->prepare("DELETE FROM reverse_socks WHERE id = :id ");
                $statement->execute(array('id' => $row["id"]));
            }else{
                $statement = $GLOBALS["pdo"]->prepare("UPDATE reverse_socks SET lastcheck = CURRENT_TIMESTAMP() WHERE id = ?");
                $statement->execute(array($row["id"]));
            }
        }
        if(!empty($_POST["ip"])){

            try{
                $reader = new Reader(__DIR__ . '/../../../src/Geo/GeoLite2-City.mmdb');
                $record = $reader->city($_POST["ip"]);
                $country = $record->country->isoCode;
                $countryName = $record->country->name;
                $countryCity = $record->city->name;

            }catch (Exception $e){
                $country = "unknow";
                $countryName = "unknow";
                $countryCity = "unknow";
            }

            if(!empty($_POST["connected"])){
                $statement = $GLOBALS["pdo"]->prepare("SEELCT * FROM reverse_socks WHERE ip = :ip");
                $result = $statement->execute(array('ip' => $_POST["ip"]));
                $user = $statement->fetch();

                if($user !== false) {
                    echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
                    $error = true;
                }else{

                    file_put_contents("socks","OK");
                    $statement = $GLOBALS["pdo"]->prepare("INSERT INTO reverse_socks (ip, status, country, country_name,country_city,lastcheck) VALUES (:ip, :status, :country, :country_name, :country_city,CURRENT_TIMESTAMP())");
                    $result = $statement->execute(array('ip' => $_POST["ip"], 'status' =>  $_POST["port"], 'country' => $country, 'country_name' => $countryName,"country_city" =>$countryCity));
                }

            }




            if(!empty($_POST["disconnected"])){
                $statement = $GLOBALS["pdo"]->prepare("DELETE FROM reverse_socks WHERE ip = :ip ");
                $result = $statement->execute(array('ip' => $_POST["ip"]));
            }
        }


        die();
    }
}
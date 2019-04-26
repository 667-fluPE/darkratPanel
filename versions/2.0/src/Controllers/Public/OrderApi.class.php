<?php

/*
 *              TODO:

- Create order (Bitcoin or Ethereum Payments) get address  //hd-wallet-derive
- Check if Payed and create Task
- Get task Info

 *
 */

class OrderApi{
    // TODO BotShop API

    function command_exist($cmd) {
        $return = shell_exec(sprintf("which %s", escapeshellarg($cmd)));
        return !empty($return);
    }

    public function checkFunctions(){
        //npm install -g vanity-eth
        $nodeinstalled = $this->command_exist("vanityeth");
        if(!$nodeinstalled){
            die("vanityeth was not Found please install it to Generate local ethereum private keys https://nodejs.org/en/");
        }
        $cmd = "vanityeth";

        die();
    }



}

?>
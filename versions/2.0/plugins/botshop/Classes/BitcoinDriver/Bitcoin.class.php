<?php

class Bitcoin{

    private $isTestnet;



    function __construct()
    {
        if($this->isTestnet){
            $this->blockchainAPI = "https://chain.so/api/v2/get_address_balance/BTCTEST/";
        }else{
            $this->blockchainAPI = "https://chain.so/api/v2/get_address_balance/BTC/";
        }
    }


}
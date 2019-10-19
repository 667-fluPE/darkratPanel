<?php


class miner{

    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("miner") . "/template/miner";
    }


    public function settings(){
        $GLOBALS["template"][1] = "settings";
    }
}
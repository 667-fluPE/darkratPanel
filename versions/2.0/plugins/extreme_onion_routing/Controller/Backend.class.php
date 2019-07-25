<?php

class Backend{

    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("extreme_onion_routing") . "/template/Backend";
    }

    public function extreme_onion_routing(){

    }

    public function manage_gates(){

        if(!empty($_POST["bind_server"])){

            die("TODO");
        }


        $statement = $GLOBALS["pdo"]->prepare("SELECT extreme_routing_server.*, extreme_routing_domains.server_domain as dns, extreme_routing_domains.description as status FROM extreme_routing_server LEFT JOIN extreme_routing_domains ON extreme_routing_server.server_domain = extreme_routing_domains.id");
        $statement->execute(array());
        $routers = array();
        while ($row = $statement->fetch()) {
            $routers[] = $row;
        }
        $GLOBALS["tpl"]->assign("allRouters", $routers);
    }

    public function manage_routers(){

        if(!empty($_POST["change_serverdomain"])){
            $statement = $GLOBALS["pdo"]->prepare("UPDATE extreme_routing_server SET server_domain = ? WHERE id = ?");
            $statement->execute(array($_POST["change_serverdomain"], $_POST["change_serverdomain_serverid"]));
        }

        if(!empty($_POST["server_ip"]) && !empty($_POST["user_name"]) && !empty($_POST["password"]) && !empty($_POST["port"]) && !empty($_POST["dns_name"])  ){
            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO extreme_routing_server (server_domain, user_name, password,port,ip,create_date) VALUES (?, ?, ?,?, ?,NOW())");
            $statement->execute(array($_POST["dns_name"], $_POST["user_name"], $_POST["password"],$_POST["port"],$_POST["server_ip"]));
        }

        if(!empty($_POST["add_domain"])){

            $statement = $GLOBALS["pdo"]->prepare("INSERT INTO extreme_routing_domains (server_domain,create_date) VALUES (?,NOW())");
            $statement->execute(array($_POST["add_domain"]));
        }



        $statement = $GLOBALS["pdo"]->prepare("SELECT extreme_routing_server.*, extreme_routing_domains.server_domain as dns, extreme_routing_domains.description as status FROM extreme_routing_server LEFT JOIN extreme_routing_domains ON extreme_routing_server.server_domain = extreme_routing_domains.id");
        $statement->execute(array());
        $routers = array();
        while ($row = $statement->fetch()) {
            $routers[] = $row;
        }



        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM extreme_routing_domains");
        $statement->execute(array());
        $domains = array();
        while ($row = $statement->fetch()) {
            $domains[] = $row;
        }

        $GLOBALS["tpl"]->assign("allDomains", $domains);
        $GLOBALS["tpl"]->assign("allRouters", $routers);

    }
}
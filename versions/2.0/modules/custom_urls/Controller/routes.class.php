<?php

class routes{

    public function options(){
        $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM routes WHERE active = ?");
        $statement->execute(array("1"));
        $allRoutes = array();

        if(!empty($_POST["changeroute"])){
            foreach ($_POST as $controller => $editRoute){
                $statement = $GLOBALS["pdo"]->prepare("UPDATE routes SET route = ? WHERE controller = ?");
                $statement->execute(array($editRoute, $controller));
            }

        }

        while($route = $statement->fetch()) {
            $allRoutes[] = $route;
        }
        $GLOBALS["tpl"]->assign("routes",$allRoutes);
    }
}
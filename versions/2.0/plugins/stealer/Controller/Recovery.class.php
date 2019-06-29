<?php

class Recovery
{


    public function upload()
    {

        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if(empty($_FILES["media"]["name"])){
            die();
        }

        $target_file = $target_dir . basename($_FILES["media"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file already exists
        if (file_exists($target_file)) {
            unlink($target_file); //remove the file
        }

// Allow certain file formats
        if ($imageFileType != "txt") {
            echo "Sorry, only txt are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["media"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["media"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        //var_dump($detailsArray);
        die();
    }


}
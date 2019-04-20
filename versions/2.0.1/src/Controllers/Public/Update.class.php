<?php


class Update{

    public  function version_check(){
        $file = fopen ($GLOBALS["ext_version_loc"], "r");
        $exploded = explode(";",fgets($file));
        $vnum = $exploded[0];
        fclose($file);
        // check users local file for version number
        $userfile = fopen (__DIR__."/../../Version/vnum_". $_POST['uid'] .".txt", "r");
        $user_vnum = fgets($userfile);
        fclose($userfile);
        if($user_vnum == $vnum){
            // data
            $data = array("version" => 0);
        }else{
            // data
            $data = array("version" => $vnum);
        }
        // send the json data
        echo json_encode($data);
        die();
    }

    public function doUpdate(){
        $file = fopen ($GLOBALS["ext_version_loc"], "r");
        $exploded = explode(";",fgets($file));
        $copy = copy($exploded[1], __DIR__."/../../Version/update.zip");
// check for success or fail
        if(!$copy){
            // data message if failed to copy from external server
            $data = array("copy" => 0);
        }else{
            // success message, continue to unzip
            $copy = 1;
        }
// check for verification
        if($copy == 1){

            $path = pathinfo(realpath($exploded[1], __DIR__."/../../Version/update.zip"), PATHINFO_DIRNAME);
            // unzip update
            $zip = new ZipArchive;
            $res = $zip->open($exploded[1], __DIR__."/../../Version/update.zip");
            if($res === TRUE){
                $zip->extractTo( $path );
                $zip->close();
                // success updating files
                $data = array("unzip" => 1);
                // delete zip file
                unlink($exploded[1], __DIR__."/../../Version/update.zip");
                // update users local version number file
                $userfile = fopen ("version/vnum_". $_POST['uid'] .".txt", "w");
                $user_vnum = fgets($userfile);
                fwrite($userfile, $_POST['vnum']);
                fclose($userfile);
            }else{
                // error updating files
                $data = array("unzip" => 0);
                // delete potentially corrupt file
                unlink($exploded[1], __DIR__."/../../Version/update.zip");
            }
        }
// send the json data
        echo json_encode($data);
        die();
    }

}
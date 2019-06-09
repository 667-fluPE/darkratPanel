<?php

class FakeErrors{


    public function cloudflare_offlinehost(){
        header('HTTP/1.1 521 Web server is down'); // Confuse bots
        $GLOBALS["template"][0] = "FakeErrors";
        $GLOBALS["template"][1] = "cloudflare_offlinehost";
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $ray_id = '';
        for ($i = 0; $i < 16; $i++) {
            $ray_id .= $characters[rand(0, $charactersLength - 1)];
        }
        $GLOBALS["tpl"]->assign("ray_id",$ray_id );
    }
}

?>
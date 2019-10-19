<?php

class Ajax{

        public function manage($type){

            switch ($type) {
                case "checkserver":
                    $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM extreme_routing_server WHERE id = ?");
                    $statement->execute(array($_POST["id"]));
                    while ($row = $statement->fetch()) {
                        $connection = ssh2_connect($row["ip"], $row["port"]);
                        ssh2_auth_password($connection,  $row["user_name"], $row["password"]);
                        $stream = ssh2_exec($connection, 'whoami');
                        stream_set_blocking($stream, true);
                        $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);

                        if(trim(stream_get_contents($stream_out)) == $row["user_name"]){
                            $status = "online";
                        }else{
                            $status = "offline";
                        }
                        fclose($stream);
                        $statement = $GLOBALS["pdo"]->prepare("UPDATE extreme_routing_server SET description = ? WHERE id = ?");
                        $statement->execute(array($status, $row["id"]));
                        echo $status;
                    }
                    break;
                case "setup":
                    //sudo apt-get install python3-dev python3-pip libffi-dev libssl-dev
//mitmproxy -p 8080 --mode reverse:https://remote.site.example.com/
                    $statement = $GLOBALS["pdo"]->prepare("SELECT * FROM extreme_routing_server WHERE id = ?");
                    $statement->execute(array($_POST["id"]));
                    while ($row = $statement->fetch()) {
                        $connection = ssh2_connect($row["ip"], $row["port"]);
                        ssh2_auth_password($connection,  $row["user_name"], $row["password"]);
                        $stream = ssh2_exec($connection, 'apt-get install python3-dev python3-pip libffi-dev libssl-dev');
                        stream_set_blocking($stream, true);
                        stream_get_contents($stream); // Wait for command to finish
                        $stream1 = ssh2_exec($connection, 'pip3 install mitmproxy');
                        stream_set_blocking($stream1, true);


                       // echo $status;
                    }


                    break;
                case "green":
                    echo "Your favorite color is green!";
                    break;
                default:
                    echo "Your favorite color is neither red, blue, nor green!";
            }

            die();
        }
}
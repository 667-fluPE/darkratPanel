<?php


class logController
{

    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("logs") . "/template/log";
    }

    public function logs()
    {
        $GLOBALS["template"][1] = "logs";
        $statement = $GLOBALS["pdo"]->prepare("SELECT logs.ip, logs.id, logs.title, users.username FROM logs LEFT JOIN users ON users.id = logs.userid");
        $statement->execute(array());
        $logs = array();
        while ($row = $statement->fetch()) {
            $logs[] = $row;
        }
        $GLOBALS["tpl"]->assign("allLogs", $logs);
    }

    public function loginfo($id)
    {
        $GLOBALS["template"][1] = "loginfo";
        echo $id;
    }

}
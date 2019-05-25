<?php




class testplugin{



    public function __construct()
    {
        $GLOBALS["template"][0] = $GLOBALS["foundPlugins"]["testplugin"]["plugindir"]."/template/testplugin";
    }

    public function dashboard(){
        $GLOBALS["template"][1] = "Dashboardoverride";
        $GLOBALS["tpl"]->assign("helloworld","Hello word, this Route is overwritten by the Test Plugin");
    }

}
<?php

class aboutConroller
{
    public function __construct()
    {
        $GLOBALS["template"][0] = get_plugin_base_dir("about") . "/template/about";
    }

    public function dashboard()
    {
        $GLOBALS["template"][1] = "about";
    }

    public function about()
    {
        $GLOBALS["template"][1] = "about";
    }
}
<!DOCTYPE html>
<html lang="en">
<head>
    <title>DarkRat Native</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{$includeDir}assets/css/datatables.css">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{$includeDir}assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{$includeDir}assets/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{$includeDir}assets/css/font.css">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{$includeDir}assets/css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{$includeDir}assets/css/bootstrap-multiselect.css">

    <link rel="stylesheet" href="{$includeDir}assets/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{$includeDir}assets/img/favicon.ico">
    <!-- jQuery library -->
    <script src="{$includeDir}assets/js/jquery.min.js"></script>
    <script src="{$includeDir}assets/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="{$includeDir}assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{$includeDir}assets/js/bootstrap-multiselect.js"></script>
    <script src="{$includeDir}assets/js/jquery.vmap.js"></script>
    <script src="{$includeDir}assets/js/datatables.js"></script>

    <script src="{$includeDir}assets/js/Chart.js"></script>
    <script src="{$includeDir}assets/js/functions.js"></script>
<!-- TODo include .DataTable -->
</head>
<body>




{if $config_done}{else}

    <div style="margin:0px; border-radius: 0; border: none;" class="alert alert-danger" role="alert">
        Your configuration is not done, go to "<a href="/settings">Global Settings</a>" and setup your panel
    </div>

{/if}



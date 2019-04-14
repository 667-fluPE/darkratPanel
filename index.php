<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/src/Classes/Bramus/Router/Router.php';
require  __DIR__ . '/src/Classes/Smarty/Smarty.class.php';
require  __DIR__ . '/src/Controllers/Public/Main.class.php';

$tpl = new Smarty;
$router = new \Bramus\Router\Router();



$router->all('/login', 'Main@login');
$router->all('/dashboard', 'Main@index');
$router->all('/tasks', 'Main@tasks');
$router->all('/logout', 'Main@logout');
$router->all('/taskdetails/(\d+)', 'Main@taskdetails');
/*
$router->get('/taskdetails/(\d+)', function($id) {
    echo 'movie id ' . htmlentities($id);
});
*/

$template = explode("@",$router->fn);
$router->run(function() use ($tpl) {
    $tpl->setTemplateDir(__DIR__."/templates/v1/");
    $templateDir = $GLOBALS["template"][0]."/".$GLOBALS["template"][1].".tpl";
    $GLOBALS["tpl"]->assign("includeDir", "/templates/v1/");
    $tpl->display($templateDir);
});




/*
    session_start();

    if(empty($_SESSION["darkrat_userid"])){
        header("Location: ?p=login");
        die();
    }

    $pdo = new PDO('mysql:host=localhost;dbname=darkratnative', 'root', 'hobbit36');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/custom.css">
    <!-- Latest compiled and minified CSS -->
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>






<nav class="navbar navbar-expand-lg navbar-dark ">
  <a class="navbar-brand" href="#">DarkRat Native</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</nav>



<div class="row">
    <div class="col-md-1 col-lg-1">
        <div class="sidebar-nav">
            <ul>
                <li> <a href="" title="Home">  <img src="assets/img/nav/home.svg"> </a></li>
                <li> <a href="" title="Tasks">  <img src="assets/img/nav/working-with-laptop.svg"> </a></li>
            </ul>

        </div>
    </div>
    <div class="col-md-11 col-lg-11">
        <div class="container">

            <div class="row">
                <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
                <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
                <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
            </div>

            <div class="row">
                <table class="table bot_table">
                    <thead>
                    <tr>
                        <th>Country</th>
                        <th>Computername</th>
                        <th>Opering System</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM bots";
                            foreach ($pdo->query($sql) as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row["country"];?></td>
                                    <td><?php echo $row["computrername"];?></td>
                                    <td><?php echo $row["operingsystem"];?></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</body>
</html>
*/
?>


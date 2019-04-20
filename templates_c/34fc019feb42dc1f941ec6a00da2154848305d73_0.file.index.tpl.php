<?php
/* Smarty version 3.1.32, created on 2019-04-20 09:54:01
  from '/var/www/html/versions/templates/v1/install/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cbaec3994df05_72551268',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '34fc019feb42dc1f941ec6a00da2154848305d73' => 
    array (
      0 => '/var/www/html/versions/templates/v1/install/index.tpl',
      1 => 1555244506,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cbaec3994df05_72551268 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { font-family: Arial; }

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
</head>
<body>

<h2>DarkRat Installer V1</h2>
<p>Computer hacking was like a chemical bond holding us all together.</p>

<div class="tab">
  <button class="tablinks" id="defaultOpen" onclick="openTab(event, 'Requirements')">Requirements</button>
  <button class="tablinks" onclick="openTab(event, 'Database')">Database</button>
  <button class="tablinks" onclick="openTab(event, 'Finishing')">Finishing</button>
</div>

<div id="Requirements" class="tabcontent">
 
    <?php if ($_smarty_tpl->tpl_vars['return']->value['mysql'] == "1") {?>
        MySql Installed
    <?php } else { ?>
        Please Install MYsql
    <?php }?>
    <hr>
    <?php if ($_smarty_tpl->tpl_vars['return']->value['writable'] == "1") {?>
        Dir is Writable
    <?php } else { ?>
        Dir is not Writable
    <?php }?>

</div>

<div id="Database" class="tabcontent">
  <h3>Create MySql</h3>

  <form method="POST">
    <label>MySQL Root Username</label>
    <input name="mysqlusername">
    <br>
    <label>MySQL Root Password</label>
    <input name="mysqlpassword">
    <hr>
    <i>This Script Creates a Database with a new user the <strong>Root Login will not be saved</strong></i>
    <hr>
    <input value="Install" type="submit">
  </form>



</div>

<div id="Finishing" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>

<?php echo '<script'; ?>
>
function openTab(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
<?php echo '</script'; ?>
>
   
</body>
</html> 
<?php }
}

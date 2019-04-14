<?php
/* Smarty version 3.1.32, created on 2019-04-13 15:18:15
  from '/var/www/html/templates/v1/nav.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cb1fdb78641d7_98276036',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '33a224e2ee5a909bd717142512ec71c8b20b1672' => 
    array (
      0 => '/var/www/html/templates/v1/nav.tpl',
      1 => 1555167667,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cb1fdb78641d7_98276036 (Smarty_Internal_Template $_smarty_tpl) {
?><nav class="navbar navbar navbar-toggleable-sm navbar-inverse bg-inverse ">
  <a style="text-decoration: none;" class="navbar-brand" href="#">DarkRat Native</a>

  <ul class="nav navbar-nav navbar-right">
    <li><a href="/logout">  <img style="width:40px;" title="Logout" src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/nav/logout.svg"> </a></li>
  </ul>
</nav>



<div class="row">
  <div class="col-md-1 col-lg-1">
      <div class="sidebar-nav">
          <ul>
              <li> <a href="/dashboard" title="Home">  <img src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/nav/home.svg"> </a></li>
              <li> <a href="/tasks" title="Tasks">  <img src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/nav/working-with-laptop.svg"> </a></li>
          </ul>
      </div>
  </div><?php }
}

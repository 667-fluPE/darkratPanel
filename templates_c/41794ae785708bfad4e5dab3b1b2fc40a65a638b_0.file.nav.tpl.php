<?php
/* Smarty version 3.1.32, created on 2019-04-20 10:29:14
  from '/var/www/html/versions/2.0.1/templates/v1/nav.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cbaf47a5a7fd1_09716487',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '41794ae785708bfad4e5dab3b1b2fc40a65a638b' => 
    array (
      0 => '/var/www/html/versions/2.0.1/templates/v1/nav.tpl',
      1 => 1555756142,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5cbaf47a5a7fd1_09716487 (Smarty_Internal_Template $_smarty_tpl) {
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
              <li> <a href="/settings" title="Settings">  <img src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/nav/settings.svg"> </a></li>
          </ul>
      </div>
  </div><?php }
}

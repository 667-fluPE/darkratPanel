<?php
/* Smarty version 3.1.32, created on 2019-04-20 09:58:39
  from '/var/www/html/versions/2.0/templates/v1/Main/login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cbaed4fab8773_95106456',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '541b2b899e27e5923cc59a71ffcb94d043128c0a' => 
    array (
      0 => '/var/www/html/versions/2.0/templates/v1/Main/login.tpl',
      1 => 1555084924,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
  ),
),false)) {
function content_5cbaed4fab8773_95106456 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="login">

    <div class='login-table'>
        <div class='login-cell'>
            <form id="login" class="login-form" method="POST">
                <label>Username:</label>
                <input type="text" name="userid" size="18" maxlength="18" />
                <br />
                <label>Password :</label>
                <input type="password" name="pswrd" size="18" maxlength="18" />
                <br />
                <a  onclick="document.getElementById('login').submit()" class="bttn">Continue</a>
            </form>
        </div>
    </div>
</div>
<?php }
}

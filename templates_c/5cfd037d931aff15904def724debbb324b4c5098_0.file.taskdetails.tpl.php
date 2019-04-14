<?php
/* Smarty version 3.1.32, created on 2019-04-14 11:00:11
  from '/var/www/html/templates/v1/Main/taskdetails.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cb312bbd5a886_39799414',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5cfd037d931aff15904def724debbb324b4c5098' => 
    array (
      0 => '/var/www/html/templates/v1/Main/taskdetails.tpl',
      1 => 1555239593,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:nav.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_5cb312bbd5a886_39799414 (Smarty_Internal_Template $_smarty_tpl) {
?> 
<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="col-md-11 col-lg-11">
        <div class="container">
                <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Country</th>
                            <th>Computrername</th>
                            <th>Opering System</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>

                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tasks']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['info']->value['country'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['info']->value['computrername'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['info']->value['operingsystem'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['info']->value['status'];?>
</td>
                            </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
          
                        </tbody>
                      </table>

        </div>
</div>
        
<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}

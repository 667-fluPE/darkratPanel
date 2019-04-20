<?php
/* Smarty version 3.1.32, created on 2019-04-20 09:58:46
  from '/var/www/html/versions/2.0/templates/v1/Main/tasks.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cbaed566d83f0_07411265',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '46a1b6c39c7ac702c31bd40b42de42d980b22462' => 
    array (
      0 => '/var/www/html/versions/2.0/templates/v1/Main/tasks.tpl',
      1 => 1555528918,
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
function content_5cbaed566d83f0_07411265 (Smarty_Internal_Template $_smarty_tpl) {
?> 
<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="col-md-11 col-lg-11">
  <div class="container">
  
      <div class="row">
    
        <div class="col-md-5 col-lg-5">
          <hr>
          <form method="POST" id="newTask"> 
          <select name="task" class="custom-select" id="inputGroupSelect01">
            <option selected disabled>Task method</option>
            <option value="dande">Download & Execute</option>
            <option value="update">Update</option>
            <option value="uninstall">Uninstall</option>
          </select>
          <div id="inputs">
          </div>
        </form>
        </div>
     
        <div class="col-md-7 col-lg-7">
           <table class="table">
              <thead>
                <tr>
                  <th colspan="2">Status</th>
                  <th>Command</th>
                  <th>Type</th>
                  <th>Executions</th>
                  <th>Task Details</th>
                </tr>
              </thead>
              <tbody>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allTasks']->value, 'task');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
?>
                <tr>
                  <td width="30">
                      <form method="post" id="delete-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
">
                        <img width="25"  onclick="document.getElementById('delete-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
').submit()" src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/delete.svg" title="Delete"> 
                        <input name="delete" value="1" hidden> 
                        <input name="taskid" value="<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
" hidden>
                      </form> 
                  </td>
                  <td width="30">
                    <?php if ($_smarty_tpl->tpl_vars['task']->value['status'] == "1") {?>
                      <form method="post" id="pause-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
">
                        <img width="25"  onclick="document.getElementById('pause-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
').submit()" src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/round-pause-button.svg" title="Currenlty Running"> 
                        <input name="taskstatus" value="pause" hidden> 
                        <input name="taskid" value="<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
" hidden>
                      </form> 
                    <?php } else { ?> 
                      <form method="post" id="run-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
">
                        <input name="taskstatus" value="run" hidden> 
                        <input name="taskid" value="<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
" hidden> 
                        <img width="25" onclick="document.getElementById('run-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
').submit()" src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/play-button.svg" title="Currenlty Paused"> 
                      </form> 
                    <?php }?>
                  </td>
                  <td><?php echo $_smarty_tpl->tpl_vars['task']->value['command'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['task']->value['task'];?>
</td>
                  <td><?php echo $_smarty_tpl->tpl_vars['task']->value['executions'];?>
</td>
                  <td><a href="/taskdetails/<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
">Show</a></td>
                </tr> 
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
              </tbody>
            </table>
        </div>
      </div>
 
  </div>
</div>







<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
echo '<script'; ?>
>
    var submit = false;
    $('#inputGroupSelect01').on('change', function() {
      $('#inputs').empty();
  
      if(this.value == "dande" || this.value == "update"){
        submit = true;
        $('#inputs').append('<hr><input value="" Placeholder="http://yourdomainorip.com/path/to/file.exe" name="command" class="form-control">');    
      }
  
      if(this.value == "uninstall"){
        submit = true;
      }
  
      if(submit){
        $('#inputs').append('<hr><a onclick="document.getElementById(\'newTask\').submit()" class="bttn">Execute Task</a>');
      }
  
  });
  <?php echo '</script'; ?>
><?php }
}

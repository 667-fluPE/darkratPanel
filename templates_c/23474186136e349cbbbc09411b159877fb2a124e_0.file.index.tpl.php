<?php
/* Smarty version 3.1.32, created on 2019-04-13 14:40:44
  from '/var/www/html/templates/v1/Main/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cb1f4eca6b408_40722981',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '23474186136e349cbbbc09411b159877fb2a124e' => 
    array (
      0 => '/var/www/html/templates/v1/Main/index.tpl',
      1 => 1555166315,
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
function content_5cb1f4eca6b408_40722981 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<!--
it's going to be hard but hard doesn't mean impossible
-->
<?php echo '<script'; ?>
>

  function timeDifference(current, previous) {
  
    var now = new Date(current*1000);
    var previous = new Date(previous*1000),

      secondsPast = (now.getTime() - previous.getTime()) / 1000;
    if(secondsPast < 60){
      return parseInt(secondsPast) + ' Secounds Ago';
    }
    if(secondsPast < 3600){
      return parseInt(secondsPast/60) + ' Minutes Ago';
    }
    if(secondsPast <= 86400){
      return parseInt(secondsPast/3600) + ' Hours Ago';
    }
    if(secondsPast > 86400){
        day = previous.getDate();
        month = previous.toDateString().match(/ [a-zA-Z]*/)[0].replace(" ","");
        year = previous.getFullYear() == now.getFullYear() ? "" :  " "+previous.getFullYear();
        return day + " " + month + year;
    }
  }
  
  <?php echo '</script'; ?>
>



<div class="col-md-11 col-lg-11">
  <div class="container">
    <!--
      <div class="row">
          <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
          <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
          <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
      </div>
    -->
      <div class="row">
          <table class="table bot_table">
              <thead>
              <tr>
                  <th>Country</th>
                  <th>IP</th>
                  <th>Computername</th>
                  <th>Opering System</th>
                  <th>Version</th>
                  <th>Last Seen</th>
              </tr>
              </thead>
              <tbody>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['allbots']->value, 'bot');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['bot']->value) {
?>
                  <tr>
                    <td class="flag">  <img src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/flags/<?php echo mb_strtolower($_smarty_tpl->tpl_vars['bot']->value['country'], 'UTF-8');?>
.png"> <?php echo $_smarty_tpl->tpl_vars['bot']->value['country'];?>
</td>
                    <td> <?php echo $_smarty_tpl->tpl_vars['bot']->value['ip'];?>
</td>
                    <td> <?php echo $_smarty_tpl->tpl_vars['bot']->value['computrername'];?>
</td>
                    <td class="operingsystem">  <img src="<?php echo $_smarty_tpl->tpl_vars['includeDir']->value;?>
assets/img/operingsystems/<?php echo $_smarty_tpl->tpl_vars['bot']->value['operingsystem'];?>
.png"> </td>
                    <td> <?php echo $_smarty_tpl->tpl_vars['bot']->value['version'];?>
 </td>
                    <td>  <span id="lastSeen-<?php echo $_smarty_tpl->tpl_vars['bot']->value['id'];?>
"></span> <?php echo '<script'; ?>
>$("#lastSeen-<?php echo $_smarty_tpl->tpl_vars['bot']->value['id'];?>
").html( timeDifference("<?php echo $_smarty_tpl->tpl_vars['bot']->value['now'];?>
","<?php echo $_smarty_tpl->tpl_vars['bot']->value['lastresponse'];?>
"))  <?php echo '</script'; ?>
> </td>
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


<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php }
}

<?php
/* Smarty version 3.1.32, created on 2019-04-20 10:39:11
  from '/var/www/html/versions/2.0/templates/v1/Main/settings.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5cbaf6cfaac004_23993196',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '273b559ff8df8d8a305e8859a5c8b58e9c0b5e22' => 
    array (
      0 => '/var/www/html/versions/2.0/templates/v1/Main/settings.tpl',
      1 => 1555756731,
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
function content_5cbaf6cfaac004_23993196 (Smarty_Internal_Template $_smarty_tpl) {
?> 
<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
$_smarty_tpl->_subTemplateRender("file:nav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="col-md-11 col-lg-11">
        <div class="container">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" href="#users" role="tab" data-toggle="tab">Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#globalsettings" role="tab" data-toggle="tab">Global Settings</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#update" role="tab" data-toggle="tab">Update</a>
                </li>
            </ul>
              
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="users">
                    <table class="table">
                        <thead>
                          <tr>
                            <th>Username</th>
                            <th>Edit</th>
                          </tr>
                        </thead>
                        <tbody>
              
                          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['users']->value, 'user');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
?>
                          <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</td>
                            <td> <a href="/edituser/<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
"> Edit </a></td>
                          </tr>
                          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
 
                        </tbody>
                      </table>
          
                </div>
                <div role="tabpanel" class="tab-pane fade" id="globalsettings">

                    <form method="POST">
                        <div class="form-group">
                            <label for="enryptionkey">Enryption Key</label>
                            <input type="text" class="form-control" name="enryptionkey" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['enryptionkey'];?>
" id="enryptionkey" aria-describedby="emailHelp" placeholder="Enter your encryption key (From bot config.h)">
                            <small id="enryptionkeyHelper" class="form-text text-muted">We'll never share your encryption key with anyone else.</small>
                        </div>
                    </form>



                </div>
                <div role="tabpanel" class="tab-pane fade" id="update">

                    <div class="updatecenter">
                     <a class="bttn version_check" id="1" style="cursor: pointer;">Check for Updates</a>
                        <div class="loading"></div>
                    </div>


                </div>
              </div>

        </div>
</div>
        
<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo '<script'; ?>
>


    // function to reorder
    $(document).ready(function(){
        // check users files and update with most recent version
        $(".version_check").on('click',function(e) {
            //$(".loading").show();
            var uid = $(this).attr("id");
            var info = "uid="+uid+"&vcheck=1";
            $.ajax({
                beforeSend: function(){
                    $(".loading").html('<br><img src="loader.gif" width="16" height="16" />');
                },
                type: "POST",
                url: "version_check",
                data: info,
                dataType: "json",
                success: function(data){
                    // clear loading information
                    $(".loading").html("");
                    // check for version verification
                    if(data.version != 0){
                        $(".version_check").remove();
                        $(".loading").html("<p><b>"+data.version+"</b> Version is Released. You are outdated</p>  <a id='1' class='bttn doUpdate'>START UPDATE</a>");


                        $(".doUpdate").on('click',function(e) {
                            //$(".loading").show();
                            var uid = $(this).attr("id");
                            var info = "uid="+uid+"&vcheck=1";
                                    // clear loading information
                                    $(".loading").html("");
                                    // check for version verification
                                    if(data.version != 0){
                                        var uInfo = "uid="+uid+"&vnum="+data.version
                                        $.ajax({
                                            beforeSend: function(){
                                                $(".loading").html('<br><img src="loader.gif" width="16" height="16" />');
                                            },
                                            type: "POST",
                                            url: "doUpdate",
                                            data: uInfo,
                                            dataType: "json",
                                            success: function(data){
                                                // check for version verification
                                                if(data.copy != 0){
                                                    if(data.unzip == 1){
                                                        // clear loading information
                                                        $(".version_check").html("");
                                                        // successful update
                                                        $(".loading").html("Successful Update!");
                                                    }else{
                                                        // error during update/unzip
                                                        $(".loading").html("<br>Sorry, there was an error with the update.");
                                                    }
                                                }
                                            },
                                            error: function() {
                                                // error
                                                $(".loading").html('<br>There was an error updating your files.');
                                            }
                                        });
                                    }
                        });


                    }else{
                        // user has the latest version already installed
                        $(".version_check").remove();
                        $(".loading").html("You already have the latest version.");
                    }
                },
                error: function() {
                    // error
                    $(".loading").html('<br>There was an error checking your latest version.');
                }
            });
        });


        // check users files and update with most recent version

    });










// wire up shown event
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    console.log("tab shown...");
    localStorage.setItem('activeTab', $(e.target).attr('href'));
});

// read hash from page load and change tab
var activeTab = localStorage.getItem('activeTab');
if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
}
<?php echo '</script'; ?>
><?php }
}

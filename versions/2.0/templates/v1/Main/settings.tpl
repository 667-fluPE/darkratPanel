 
{include file="header.tpl"}
{include file="nav.tpl"}


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
              
                          {foreach from=$users item=user}
                          <tr>
                            <td>{$user.username}</td>
                            <td> <a href="/edituser/{$user.id}"> Edit </a></td>
                          </tr>
                          {/foreach}
 
                        </tbody>
                      </table>
          
                </div>
                <div role="tabpanel" class="tab-pane fade" id="globalsettings">
                    <form method="POST">
                        <div class="form-group">
                            <label for="enryptionkey">Enryption Key</label>
                            <input type="text" class="form-control" name="enryptionkey" value="{$config.enryptionkey}" id="enryptionkey" aria-describedby="emailHelp" placeholder="Enter your encryption key (From bot config.h)">
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
        
{include file="footer.tpl"}

<script>


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
</script>
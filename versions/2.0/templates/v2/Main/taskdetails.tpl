


<ul class="nav nav-pills">
    <li><a data-toggle="pill" class="active" href="#home">Task Info</a></li>
    <li><a data-toggle="pill" href="#menu1">Load Info</a></li>
</ul>

<div class="tab-content">
    <div id="home" class="tab-pane active">
        {if $tasks}
            <h3>Task #{$tasks[0].taskid}
                {if $tasks[0].taskstatus}
                    <span class="dot online"></span>
                {else}
                    <span class="dot offline"></span>
                {/if}
            </h3>

            <p><strong>Command: </strong> {$tasks[0].command}</p>
            <hr>
            {if $tasks[0].filter}
                TODO Show Filter
            {else}
                No filter Found
            {/if}

        {else}
            <h3>No Executions</h3>
        {/if}
    </div>
    <div id="menu1" class="tab-pane fade">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Computrername</th>
                <th>Opering System</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$tasks item=info}
                <tr>
                    <td>{$info.computrername}</td>
                    <td>{$info.operingsystem}</td>
                    <td>{$info.status}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>

</div>


        


<script>
  //  generateWordMap({$worldmap});
</script>

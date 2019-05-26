
{include file="header.tpl"}
{include file="nav.tpl"}


<div class="col-md-12 col-lg-11">
   Log Template
    <table class="table">
        {foreach from=$allLogs item=log}
            <tr>
                <td>{$log.title}</td>
                <td>{$log.ip}</td>
                <td>{$log.username}</td>
                <td><a href="/loginfo/{$log.id}">Inspect Request</a></td>
            </tr>
        {/foreach}
    </table>
</div>


{include file="footer.tpl"}
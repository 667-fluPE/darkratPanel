


<table>
<tr>
    <th>Botid</th>
    <th>Taskid</th>
    <th>Active</th>
</tr>
    {foreach from=$bots item=bot}

        <tr>
            <td>{$bot.botid}</td>
            <td>{if !$bot.ddos_taskid} Waiting {else} {$bot.ddos_taskid} {/if}</td>
            <td>{if !$bot.active} Waiting {else} Active {/if}</td>
        </tr>

    {/foreach}
</table>



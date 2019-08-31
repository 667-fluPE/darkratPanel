
{include file="header.tpl"}
{include file="nav.tpl"}

<table class="table">
    <tr>
        <th>Country</th>
        <th>IP</th>
        <th>Port</th>
    </tr>
    {foreach from=$all item=socks}
        <tr>
            <td>{$socks.country}</td>
            <td>{$socks.ip}</td>
            <td>{$socks.status}</td>
        </tr>
    {/foreach}

</table>

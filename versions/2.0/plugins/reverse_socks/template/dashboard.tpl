
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
            <td>  <img width="16" src="{$includeDir}assets/img/flags/flags/{$socks.country|lower}.png">  {$socks.country}</td>
            <td>{$socks.ip}</td>
            <td>{$socks.status}</td>
            <td>{$socks.lastcheck}</td>
        </tr>
    {/foreach}

</table>

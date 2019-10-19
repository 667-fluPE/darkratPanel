
{include file="header.tpl"}
{include file="nav.tpl"}


    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
        </div>
    </div>

    <div class="col-md-12 col-lg-12">
        <div class="container">

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
    </div>
    </div>

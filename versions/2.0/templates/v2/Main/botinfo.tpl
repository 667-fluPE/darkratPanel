

<table class="botinfo">
    <tr>
        <td>Hardware UUID</td>
        <td>{$botinfo.hwid}</td>
    </tr>
    <tr>
        <td>IP Address</td>
        <td>{$botinfo.ip}</td>
    </tr>
    <tr>
        <td>Computer Name</td>
        <td>{$botinfo.computrername}</td>
    </tr>
    <tr>
        <td>Processor Architecture</td>
        <td>{$botinfo.architecture}</td>
    </tr>
    <tr>
        <td>CPU Model</td>
        <td>{$botinfo.cpu}</td>
    </tr>

    <tr>
        <td>Admin</td>
        <td>
            {if $botinfo.isadmin == "true"}
                <img src="{$includeDir}assets/img/img/checked.svg" width="20" height="20">
            {else}
                <img src="{$includeDir}assets/img/img/error.svg" width="20" height="20">
            {/if}
        </td>
    </tr>

    <tr>
        <td>Antivirus</td>
        <td>{$botinfo.antivirus}</td>
    </tr>
    <tr>
        <td>Spread Tag</td>
        <td>{$botinfo.spreadtag}</td>
    </tr>
    <tr>
        <td>Last Seen</td>
        <td>{$botinfo.lastresponse}</td>
    </tr>
    <tr>
        <td>Install Date</td>
        <td>{$botinfo.install_date}</td>
    </tr>
    <tr>
        <td>Opering System</td>
        <td>{$botinfo.operingsystem}</td>
    </tr>
    <tr>
        <td>Country Name</td>
        <td><img class="flag" src="{$includeDir}assets/img/img/flags/{$botinfo.country|lower}.png"> |  {$botinfo.country}  |  {$botinfo.countryName}</td>
    </tr>
    <tr>
        <td>.Net2 Installed</td>
        <td>
            {if $botinfo.netframework2 == "true"}
                <img src="{$includeDir}assets/img/img/checked.svg" width="20" height="20">
            {else}
                <img src="{$includeDir}assets/img/img/error.svg" width="20" height="20">
            {/if}
        </td>
    </tr>
    <tr>
        <td>.Net3 Installed</td>
        <td>
            {if $botinfo.netframework3 == "true"}
                <img src="{$includeDir}assets/img/img/checked.svg" width="20" height="20">
            {else}
                <img src="{$includeDir}assets/img/img/error.svg" width="20" height="20">

            {/if}
        </td>
    </tr>
    <tr>
        <td>.Net3.5 Installed</td>
        <td>
            {if $botinfo.netframework35 == "true"}
                <img src="{$includeDir}assets/img/img/checked.svg" width="20" height="20">
            {else}
                <img src="{$includeDir}assets/img/img/error.svg" width="20" height="20">
            {/if}
        </td>
    </tr>
    <tr>
        <td>.Net4 Installed</td>
        <td>
            {if $botinfo.netframework4 == "true"}
                <img src="{$includeDir}assets/img/img/checked.svg" width="20" height="20">
            {else}
                <img src="{$includeDir}assets/img/img/error.svg" width="20" height="20">
            {/if}
        </td>
    </tr>
    <tr>
        <td>Latitude</td>
        <td>{$botinfo.latitude}</td>
    </tr>
    <tr>
        <td>Longitude</td>
        <td>{$botinfo.longitude}</td>
    </tr>
    <tr>
        <td>Bot Version</td>
        <td>{$botinfo.version}</td>
    </tr>
</table>
<hr>

<a href="/tasks/{$botinfo.id}" class="btn btn-dark">Execute Task on this Bot</a>
<hr>
<form method="post" action="/botinfo/{$botinfo.id}">
    <input value="{$botinfo.id}" name="botid" hidden>
    <input type="submit" class="btn btn-danger" name="delete_bot" value="Delete this Bot">
</form>




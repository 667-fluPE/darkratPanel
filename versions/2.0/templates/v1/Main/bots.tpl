
{include file="header.tpl"}
{include file="nav.tpl"}

<div class="col-md-12 col-lg-11">
    <div class="container">
<div class="row">
    <table class="table bot_table">
        <thead>
        <tr>
            <th>Country</th>
            <th class="hideTablet">IP</th>
            <th  class="hideMobile">Computername</th>
            <th class="hideTablet">Antivirus</th>
            <th class="hideTablet">Opering System</th>
            <th>Version</th>
            <th  class="hideMobile">Last Seen</th>
            <th>More Infos</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$allbots item=bot}
            <tr>
                <td class="flag">  <img src="{$includeDir}assets/img/flags/{$bot.country|lower}.png"> {$bot.country}</td>
                <td class="hideTablet"> {$bot.ip}</td>
                <td  class="hideMobile"> {$bot.computrername}</td>
                <td class="avtivirus hideTablet">  <img src="{$includeDir}assets/img/av/{$bot.antivirus}.png"  width="120" height="28"> </td>
                <td class="operingsystem hideTablet">  <img src="{$includeDir}assets/img/operingsystems/{$bot.operingsystem}.png"> </td>
                <td> {$bot.version} </td>
                <td class="hideMobile"> <span id="lastSeen-{$bot.id}"></span> <script>$("#lastSeen-{$bot.id}").html( timeDifference("{$bot.now}","{$bot.lastresponse}")) </script> </td>
                <td>
                    <a href="/botinfo/{$bot.id}">More Infos</a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>

        <script>

            $('.bot_table').DataTable();
        </script>
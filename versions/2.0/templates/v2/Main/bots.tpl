{include file="header.tpl"}
{include file="nav.tpl"}


<script>

    //  $('.bot_table').DataTable();

    function openBotInfo(id){

        var route = "{$defaulRoutes["Main@botinfo"]}";
        route = route.replace("(d+)","");
        $.get(route+id, function( data ) {
            $("#botinfoModal").modal( { show: true } );
            $( "#botInformations" ).html( data );

        });
    }
</script>

<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Bots Overview</h2>
    </div>
</div>

<div class="col-md-12 col-lg-12">
    <div class="">
        <div class="row">

            <!--
            <div>
                <input class="btn-dark btn" type="submit" name="clearBotlist" value="Delete All Bots">
                <hr>
            </div>
            -->

    <table   id="test1" class="table bot_table ">
        <thead>
        <tr>
            <th>Country</th>
            <th class="hideTablet">IP</th>
            <th  class="hideMobile">Computername</th>
            <th class="hideTablet">Antivirus</th>
            <th class="hideTablet">Opering System</th>
            <th>Version</th>
            <th  class="hideMobile">Last Seen</th>


        </tr>
        </thead>
        <tbody>
        {foreach from=$allbots item=bot}
            <tr  class="task" data-id="{$bot.id}">
                <td class="flag">  <img width="16" src="{$includeDir}assets/img/flags/flags/{$bot.country|lower}.png"> {if $bot.countryName == "unknow"} N/A {else} {$bot.countryName} {/if} </td>
                <td class="hideTablet"> {$bot.ip}</td>
                <td  class="hideMobile">{$bot.computrername}</td>
                <td class="avtivirus hideTablet"> {$bot.antivirus} </td>
                <td class="operingsystem hideTablet"> {$bot.operingsystem} </td>
                <td> {$bot.version} </td>
                <td class="hideMobile" data-order="{$bot.lastresponse}"> <span id="lastSeen-{$bot.id}"></span> <script>$("#lastSeen-{$bot.id}").html( timeDifference("{$bot.now}","{$bot.lastresponse}")) </script> </td>


            </tr>
        {/foreach}
        </tbody>
    </table>

        </div>
        </div>
        </div>
        <!-- The Modal -->
        <div class="modal" id="botinfoModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Bot Info</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div id="botInformations" class="modal-body">

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


</div>
</div>

<nav id="context-menu" class="context-menu">
    <ul class="context-menu__items">
        <li class="context-menu__item">
            <a href="#" class="context-menu__link" data-action="details"><i class="fa fa-eye"></i> Bot Details</a>
        </li>
        <li style="display:none;"  class="context-menu__item">
            <a href="#" class="context-menu__link" ><i class="icon-list"></i> Tasks</a>
            <ul style="display:none;" class="context-menu__items">

                    {foreach from=$task_configuration key=taskkey item=task}
                            <li class="context-menu__item">
                                    <a class="context-menu__link" href="#" data-value="{if !empty($task.value)}{$task.value}{/if}" data-placeholder="{if !empty($task.placeholder)} {$task.placeholder} {/if}" value="{$task.command|trim}">{$task.name}- {$taskkey}</a>
                            </li>
                    {/foreach}

            </ul>
        </li>

    </ul>
</nav>

<script>
    (function() {

    "use strict";

    //////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    //
    // H E L P E R    F U N C T I O N S
    //
    //////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////

    function clickInsideElement( e, className ) {
    var el = e.srcElement || e.target;

    if ( el.classList.contains(className) ) {
    return el;
    } else {
    while ( el = el.parentNode ) {
    if ( el.classList && el.classList.contains(className) ) {
    return el;
    }
    }
    }

    return false;
    }


    function getPosition(e) {
    var posx = 0;
    var posy = 0;

    if (!e) var e = window.event;

    if (e.pageX || e.pageY) {
    posx = e.pageX;
    posy = e.pageY;
    } else if (e.clientX || e.clientY) {
    posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
    posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
    }

    return {
    x: posx,
    y: posy
    }
    }

    //////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
    //
    // C O R E    F U N C T I O N S
    //
    //////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////


    var contextMenuClassName = "context-menu";
    var contextMenuItemClassName = "context-menu__item";
    var contextMenuLinkClassName = "context-menu__link";
    var contextMenuActive = "context-menu--active";

    var taskItemClassName = "task";
    var taskItemInContext;

    var clickCoords;
    var clickCoordsX;
    var clickCoordsY;

    var menu = document.querySelector("#context-menu");
    var menuItems = menu.querySelectorAll(".context-menu__item");
    var menuState = 0;
    var menuWidth;
    var menuHeight;
    var menuPosition;
    var menuPositionX;
    var menuPositionY;

    var windowWidth;
    var windowHeight;


    function init() {
    contextListener();
    clickListener();
    keyupListener();
    resizeListener();
    }


    function contextListener() {
    document.addEventListener( "contextmenu", function(e) {
    taskItemInContext = clickInsideElement( e, taskItemClassName );

    if ( taskItemInContext ) {
    e.preventDefault();
    toggleMenuOn();
    positionMenu(e);
    } else {
    taskItemInContext = null;
    toggleMenuOff();
    }
    });
    }


    function clickListener() {
    document.addEventListener( "click", function(e) {
    var clickeElIsLink = clickInsideElement( e, contextMenuLinkClassName );

    if ( clickeElIsLink ) {
    e.preventDefault();
    menuItemListener( clickeElIsLink );
    } else {
    var button = e.which || e.button;
    if ( button === 1 ) {
    toggleMenuOff();
    }
    }
    });
    }


    function keyupListener() {
    window.onkeyup = function(e) {
    if ( e.keyCode === 27 ) {
    toggleMenuOff();
    }
    }
    }

    function resizeListener() {
    window.onresize = function(e) {
    toggleMenuOff();
    };
    }


    function toggleMenuOn() {
    if ( menuState !== 1 ) {
    menuState = 1;
    menu.classList.add( contextMenuActive );
    }
    }


    function toggleMenuOff() {
    if ( menuState !== 0 ) {
    menuState = 0;
    menu.classList.remove( contextMenuActive );
    }
    }


    function positionMenu(e) {
    clickCoords = getPosition(e);
    clickCoordsX = clickCoords.x;
    clickCoordsY = clickCoords.y;

    menuWidth = menu.offsetWidth + 4;
    menuHeight = menu.offsetHeight + 4;

    windowWidth = window.innerWidth;
    windowHeight = window.innerHeight;

    if ( (windowWidth - clickCoordsX) < menuWidth ) {
    menu.style.left = windowWidth - menuWidth + "px";
    } else {
    menu.style.left = clickCoordsX + "px";
    }

    if ( (windowHeight - clickCoordsY) < menuHeight ) {
    menu.style.top = windowHeight - menuHeight + "px";
    } else {
    menu.style.top = clickCoordsY + "px";
    }
    }


    function menuItemListener( link ) {
        console.log( "Task ID - " + taskItemInContext.getAttribute("data-id") + ", Task action - " + link.getAttribute("data-action"));

        if(link.getAttribute("data-action")  == "details"){
            openBotInfo(taskItemInContext.getAttribute("data-id"));
        }

        toggleMenuOff();
    }

    /**
    * Run the app.
    */
    init();

    })();
</script>



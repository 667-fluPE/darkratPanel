
{include file="header.tpl"}
{include file="nav.tpl"}

<div class="page-header">
    <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">Bulletproof Gates</h2>
    </div>
</div>


<div class="wrapper">
    <div class="row">
        <div class="col-md-12">

            <div class="create_gist">
                <form method="post" >
                    <select name="bind_server">
                        {foreach from=$allRouters item=server}
                            <option value="{$server.id}">{$server.server_domain} - {$server.ip}</option>
                        {/foreach}
                    </select>
                    <input type="submit" value="Create Gist">
                </form>
            </div>


        </div>
    </div>
</div>



{include file="footer.tpl"}



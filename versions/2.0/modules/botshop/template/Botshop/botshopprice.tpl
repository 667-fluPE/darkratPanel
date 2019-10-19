
{include file="header.tpl"}
{include file="nav.tpl"}


<form method="post" >
    <label for="default_bot_price">Create Worldmix Bot Price</label>
    <input class="form-control" id="default_bot_price" name="default_bot_price">
    <input  style="" type="submit" class="btn btn-danger"  value="Create Price">
</form>
<hr>
<form method="post">
    <input  style="width: 100%" type="submit" class="btn btn-danger" name="sync_countries" value="Sync Country List with Botlist">
</form>
<br>

<form method="post">
    <input name="saveprice" value="1" style="display: none;">
    <table class="table">
        <thead>
        <tr>
            <th>Country</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$prices item=price_item}
            <tr>
                <th>  <img width="16" src="{$includeDir}assets/img/flags/flags/{$price_item.iso_short|lower}.png">    {$price_item.iso_short}</th>
                <th>  <input name="country[{$price_item.iso_short}]" type="text" class="form-control" value="{$price_item.price_usd}"></th>
            </tr>
        {/foreach}
        </tbody>
    </table>

    <input type="submit" class="btn btn-danger"  value="Save Prices">
</form>


{include file="footer.tpl"}
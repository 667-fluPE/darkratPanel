
{include file="header.tpl"}
{include file="nav.tpl"}


<form method="post">
    <input type="submit" name="sync_countries" value="Sync Country List with Botlist">
</form>


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

    <input type="submit"  value="Save Prices">
</form>


{include file="footer.tpl"}
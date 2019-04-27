
{include file="header.tpl"}
{include file="nav.tpl"}

<!--
it's going to be hard but hard doesn't mean impossible
-->

<div class="col-md-12 col-lg-11">


    <table class="table">
        <tr>
            <th>Site</th>
            <th>Cookiename</th>
            <th>Username</th>
            <th>Password</th>
        </tr>
        {foreach from=$userinfo item=user}
            <tr>
                <td>{$user.site}</td>
                <td>{$user.cookiename}</td>
                <td>{$user.username}</td>
                <td>{$user.password}</td>
            </tr>
        {/foreach}

    </table>

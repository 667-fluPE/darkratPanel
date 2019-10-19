{include file="header.tpl"}
{include file="nav.tpl"}

<!--
it's going to be hard but hard doesn't mean impossible
-->

<div class="col-md-12 col-lg-11">

    <table class="table">
        <thead>
        <tr>
            <th>Website</th>
            <th>Username</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody >
        {foreach from=$allusers item=user}
            <tr>
                <td style="     word-break: break-word;"><a style="     word-break: break-word;" href="{$user.site}"> {$user.site}</a></td>
                <td>{$user.username}</td>
                <td>{$user.password}</td>
                <td> <a href="/cookiemanager/{$user.id}">Cookie Infos & Management</a> </td>
            </tr>
        {/foreach}
        </tbody>
    </table>
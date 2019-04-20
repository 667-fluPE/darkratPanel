 
{include file="header.tpl"}
{include file="nav.tpl"}


<div class="col-md-11 col-lg-11">
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>Country</th>
                    <th>Computrername</th>
                    <th>Opering System</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$tasks item=info}
                        <tr>
                            <td>{$info.country}</td>
                            <td>{$info.computrername}</td>
                            <td>{$info.operingsystem}</td>
                            <td>{$info.status}</td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
</div>
        
{include file="footer.tpl"}
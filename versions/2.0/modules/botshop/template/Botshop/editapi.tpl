
{include file="header.tpl"}
{include file="nav.tpl"}


<div class="col-md-12 col-lg-11">

    <div class="card" style="width: 100%;">

        <div class="card-body">
            <h5 class="card-title">   {$apidetails.apikey}</h5>

<form method="post">
    <h5 class="card-title">

        {if $apidetails.sandbox == 1}
            <div class="alert alert-warning" role="alert">
                Sandbox Active
            </div>
            <input type="submit" name="changesandbox" class="form-control" value="Change to Main Network">
        {else}
            <div class="alert alert-success" role="alert">
                Mainnet Active
            </div>
            <input type="submit" name="changesandbox" class="form-control" value="Change to Sandbox">
        {/if}

    </h5>
</form>







        </div>
    </div>

<table class="table">
        <thead>
        <tr>
            <th>Status</th>

            <th>Load Amount</th>
            <th>Load Url</th>
            <th>Price</th>
            <th>Botshop User</th>
            <th>Task</th>

        </tr>
        </thead>
    <tbody>
    {foreach from=$orders item=order}
       <tr>
           <td>
           {if $order.payed}
            Payed
           {else}
               Not Payed
           {/if}
           </td>

           <td>   {$order.botamount}</td>
           <td>   {$order.loadurl}</td>
           <td>   {$order.coinstopay}  {$order.type} |  {$order.usd} $</td>
           <td>   {$order.userauthkey}</td>
           {if $order.taskid == "none"}
                <td>No task Active</td>
               {else}
               <td><a href="/taskdetails/{$order.taskid}">Go to Task</a></td>
           {/if}

       </tr>
    {/foreach}
    </tbody>
</table>
</div>


{include file="footer.tpl"}
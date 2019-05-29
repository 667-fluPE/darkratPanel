
{include file="header.tpl"}
{include file="nav.tpl"}


<div class="col-md-12 col-lg-11">

    <div class="card" style="width: 100%;">

        <div class="card-body">
            <h5 class="card-title">   {$apidetails.apikey}</h5>
TODO Sandbox Switch



        </div>
    </div>

<table class="table">
        <thead>
        <tr>
            <th>Status</th>
            <th>Address</th>
            <th>Key</th>
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
           <td>   {$order.address_short}</td>
           <td>   {$order.privatekey_short}</td>
           <td>   {$order.botamount}</td>
           <td>   {$order.loadurl}</td>
           <td>   {$order.coinstopay}  |  {$order.usd} $</td>
           <td>   {$order.userauthkey}</td>
           {if $order.taskid == "none"}
                <td>No task Active</td>
               {else}
               <td>   <a href="/taskdetails/{$order.taskid}">Go to Task</a></td>
           {/if}

       </tr>
    {/foreach}
    </tbody>
</table>
</div>


{include file="footer.tpl"}
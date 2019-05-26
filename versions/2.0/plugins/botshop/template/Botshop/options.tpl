
    <form method="POST">
        <input type="submit" name="create_new_shop_api" class="btn btn-dark" value="Create new API Access token">
    </form>

    <div class="shop_api_access">
        <ul class="list-group">
            {foreach from=$botshopAccessList item=botshopApi}
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="username"> Created By: {$botshopApi.username}  </div>
                            <div class="profit"> BTC Income: {$botshopApi.profit}  </div>
                        </div>
                        <div class="col-md-6">
                            <div class="apikey">
                                Access Token: {$botshopApi.apikey}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <form method="post" id="delete-{$botshopApi.id}">
                                <img width="25"  onclick="document.getElementById('delete-{$botshopApi.id}').submit()" src="{$includeDir}assets/img/delete_dark.svg" title="Delete">
                                <input name="deleteapi" value="{$botshopApi.id}" hidden>
                                <input name="apikey" value="{$botshopApi.apikey}" hidden>
                            </form>
                        </div>
                    </div>
                </li>
            {/foreach}
        </ul>
    </div>


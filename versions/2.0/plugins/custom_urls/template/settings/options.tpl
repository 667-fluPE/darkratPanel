

<div class="shop_api_access">

   <form method="post">
       <div class="form-row align-items-center">
           {foreach from=$routes item=$route}
               <div class="col-5">
                   <label class="sr-only" for="inlineFormInputGroup">{$route.controller}</label>
                   <div class="input-group mb-2">
                       <div class="input-group-prepend">
                           <div class="input-group-text">{$route.controller}</div>
                       </div>
                       <input type="text" name="{$route.controller}" class="form-control" id="inlineFormInputGroup" value="{$route.route}">
                   </div>
               </div>
           {/foreach}
       </div>
       <input type="submit" value="Save" class="btn btn-light">
       <input value="changeroute" name="changeroute" hidden>
   </form>
</div>


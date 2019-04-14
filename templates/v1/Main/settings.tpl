 
{include file="header.tpl"}
{include file="nav.tpl"}


<div class="col-md-11 col-lg-11">
        <div class="container">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" href="#users" role="tab" data-toggle="tab">Users</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#globalsettings" role="tab" data-toggle="tab">Global Settings</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#update" role="tab" data-toggle="tab">Update</a>
                </li>
            </ul>
              
              <!-- Tab panes -->
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="users">
                    <table class="table">
                        <thead>
                          <tr>
                            <th>Username</th>
                            <th>Edit</th>
                          </tr>
                        </thead>
                        <tbody>
              
                          {foreach from=$users item=user}
                          <tr>
                            <td>{$user.username}</td>
                            <td> <a href="/edituser/{$user.id}"> Edit </a></td>
                          </tr>
                          {/foreach}
 
                        </tbody>
                      </table>
          
                </div>
                <div role="tabpanel" class="tab-pane fade" id="globalsettings">bbb</div>
                <div role="tabpanel" class="tab-pane fade" id="update">ccc</div>
              </div>

        </div>
</div>
        
{include file="footer.tpl"}

<script>
// wire up shown event
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    console.log("tab shown...");
    localStorage.setItem('activeTab', $(e.target).attr('href'));
});

// read hash from page load and change tab
var activeTab = localStorage.getItem('activeTab');
if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
}
</script>
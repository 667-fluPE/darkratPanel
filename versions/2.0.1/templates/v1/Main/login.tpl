{include file="header.tpl"}


<div class="login">

    <div class='login-table'>
        <div class='login-cell'>
            <form id="login" class="login-form" method="POST">
                <label>Username:</label>
                <input type="text" name="userid" size="18" maxlength="18" />
                <br />
                <label>Password :</label>
                <input type="password" name="pswrd" size="18" maxlength="18" />
                <br />
                <a  onclick="document.getElementById('login').submit()" class="bttn">Continue</a>
            </form>
        </div>
    </div>
</div>

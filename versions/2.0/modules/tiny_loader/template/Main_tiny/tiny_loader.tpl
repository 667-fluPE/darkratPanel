
{include file="header.tpl"}
{include file="nav.tpl"}

<!--
it's going to be hard but hard doesn't mean impossible
-->

    <form class="box" method="POST" enctype="multipart/form-data">
        <div>Upload Binaries</div>
        <input type="hidden" name="time" value="1566590245.4234">
        <table>
            <tbody><tr><td>x64</td><td><input type="file" name="x64_bin"></td></tr>
            <tr><td>x86</td><td><input type="file" name="x86_bin"></td></tr>
            <tr><td></td><td><input type="submit" class="btn" value="Upload"></td></tr>
            </tbody></table>
    </form>

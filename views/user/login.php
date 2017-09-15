<?php
require_once "../layout/header.php";

$errorCode=0;
$errorMsg="";
if(isset($_SESSION["loginError"]))
{
    $errorMsg=$_SESSION["loginError"]["errMsg"];
    $errorCode=$_SESSION["loginError"]["errCode"];
}
if(!empty($_SESSION)){
    if($_SESSION["userLogin"]==1)
    {
        $rootViews =$rootView."home/home.php";
        print("<script>window.location='" . $rootViews . "'</script>");
    }
}


?>
<div style="width:70%;margin: 0 auto;background-color:#f7f9fa;padding:20px">
<form class="form-horizontal" name="loginFormName" id="loginFormId" action="../../controllers/user/Login.php"  method="POST">
    <fieldset>
        <legend>Signup</legend>
        <div class="form-group">
            <label for="inputEmail" class="col-lg-2 control-label">Email</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name='user_email' id="inputEmail" placeholder="Email">
            </div>
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-lg-2 control-label">Password</label>
            <div class="col-lg-10">
                <input type="password" class="form-control" name='user_password' id="inputPassword" placeholder="Password">
            </div>
        </div>
        <div class="form-group has-error">
            <div class="col-lg-10 pull-right">
                <span id="err_login_response" class="help-block"><?php echo $errorMsg; ?></span>
            </div>
        </div>


        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="button" id="submitLoginFrm" class="btn btn-primary">Login</button>
            </div>
        </div>
    </fieldset>
</form>
</div>
<?php
unset($_SESSION["loginError"]);
require_once "../layout/footer.php";
?>
<script>


    $( "#submitLoginFrm" ).click(function() {
        var emailHandle = $("#inputEmail").val();
        var password = $("#inputPassword").val();

        if(emailHandle!="" && password!="")
        {
            $( "#loginFormId" ).submit();
        }else {
            $("#err_login_response").html('All fields are mandatory.');
        }

    });
</script>

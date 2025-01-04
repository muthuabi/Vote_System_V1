<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
include_once("../util_classes/Admin.php");
if(isset($_POST['change_pass']))
{
    if($admin->change_admin_password($_POST['new_pass'],$_SESSION['admin']))
    {
        echo "<script>alert('Changed')</script>";
    }
    else
    {
        echo "<script>alert('UnChanged')</script>";
    }
}
?>
<div id="change_pass_container" class="position-fixed justify-content-center align-items-center" style="z-index:10000;height:85vh;width:100%">
    <form action='' method='post' class="bg-light d-flex flex-column gap-2" style="padding:1.5rem 1rem;width:350px">
    <h4 class="text-center">Change Password</h4>    
    <div class="form-group">
            <label for="old_pass">New Password</label>
            <input type="password" name="new_pass" id="new_pass" required class="form-control">
        </div>
        <div class="form-group">
            <label for="new_pass">confirm Password</label>
            <input type="password" name="confirm_new_pass" id="confirm_pass" required class="form-control">
        </div>
        <button class="btn btn-primary" type="submit" id="change_pass" name="change_pass">Change</button>
    </form>
</div>
</body>
<script>
    const old_pass=document.getElementById('new_pass');
    const new_pass=document.getElementById('confirm_pass');
    const change=document.getElementById('change_pass');
    new_pass.addEventListener("keyup",(e)=>{
        if(e.target.value==old_pass.value)
        {
            change.disabled=false;
        }
        else
        {
            change.disabled=true;
        }
    })

</script>
</html>
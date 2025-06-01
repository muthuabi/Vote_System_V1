<?php
    session_start();
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && isset($_SESSION['admin_role']) && $_SESSION['admin_role']=='sub-admin')
    {
        header("location:dashboard.php");
    }
    else
    {
        http_response_code(404);
        header("location:../admin/login.php");
    }
?>

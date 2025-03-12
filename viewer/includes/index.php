<?php
    header("HTTP/1.1 404 Page Not Found");
    exit;
    session_start();
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && isset($_SESSION['admin_role']) && $_SESSION['admin_role']=='admin')
    {
        header("location:../dashboard.php");
    }
    else
    {
        http_response_code(404);
        header("location:../login.php");
    }
?>

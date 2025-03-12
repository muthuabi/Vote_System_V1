<?php 
    //error_reporting(E_ALL && ~E_WARNING);
    header('HTTP/1.1 404 Page Not Found');
    exit;
    session_start();
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && (isset($_SESSION['admin_role']) && $_SESSION['admin_role']=='admin'))
    {
        $admin=$_SESSION['admin'];
    }
    else
    {
        header('HTTP/1.1 403 Access Forbidden');
        exit;
        http_response_code(403);
        echo "<center><b>Access Forbidden<br>
            <a href='login.php'class='btn btn-link opacity-hover'>Login to Access</a>
        </b></center>";
        exit();
    }
    if(isset($_POST['admin_logout']))
    {
        session_destroy();
        header("Location:../admin/login.php");
    }

?>
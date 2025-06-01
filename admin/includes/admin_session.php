<?php
session_start();
if(isset($_SESSION['admin']) && !empty($_SESSION['admin']))
{
    $admin=$_SESSION['admin'];
}
else
{
    header('HTTP/1.1 403 Access Forbidden');
    http_response_code(403);
    exit();
}
?>
<?php 

header('HTTP/1.1 403 Access Forbidden');
exit;
http_response_code(403);
echo "<center><b>Access Forbidden<br>
    <a href='login.php'class='btn btn-link opacity-hover'>Login to Access</a>
</b></center>";
exit();
?>
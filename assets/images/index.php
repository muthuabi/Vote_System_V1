<?php 
header('HTTP/1.1 404 Page Not Found');
http_response_code(403);
echo "<center><b>Access Forbidden<br>
   </center>";
exit();
?>
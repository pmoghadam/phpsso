<?php include ('logincheck.php'); ?>
You are logged in
<a href=logout.php> Logout </a> <br>
<?php echo "I'm http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

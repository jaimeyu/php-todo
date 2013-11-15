<?php 

ob_start();
session_start(); 
$_SESSION = array(); //kills session

session_destroy();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>You have been logged out successfully. </title>
</head>
<body>
<a href= "addToDoList.php"> New To Do Item</a>  ||  
<a href= "viewToDoList.php"> View To Do Item</a>  ||  
<a href= "logout.php"> Log out of Account</a>  ||  <br/>
<br/>

    	You have been logged out. 

    
    <?php
	?>
    </body>

</html>
<?php
ob_start();
session_start(); 

require("db.php");

#define LOGIN 0
#define TEST 1

$mode = LOGIN; //
$success = false;
if (isset($_POST['user']) || isset($_POST['password'])){
	$mode = TEST;
	$user = $_POST['user'] . "";
	$password = $_POST['password'] . "";
}

if ($mode == TEST){

	
	if (strcmp($user, "test") == 0) {
		if (strcmp($password, "test") == 0) {
			$success = true;
			$_SESSION['user'] = 2;
		}
	}
else if (strcmp($user, "test2") == 0) {
		if (strcmp($password, "test2") == 0) {
			$success = true;
			$_SESSION['user'] = 1;
		}
	}
	else{
		$sucess = false;
	}
}





if ( $success == true ){
	

	header("location:viewToDoList.php");
}
else {
	$_SESSION = array(); //kills session
	session_destroy();
	
}


ob_end_flush();

?>

<html>
<head>
<title>Login Please</title>
</head>

<body>
<?php
if ($success == false && $mode == TEST) {
	echo "Login Failed<br/>";
}
else {
	echo "Please login. <br/>";
}
?>

<form action='login.php' method='post' name=login>
User: <input name='user' type='text' value='user' /> 
Password: <input name='password' type='password' value='password' /> 
<input type='submit' value='login'></form>

</body>

</html>

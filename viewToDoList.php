<?php

ob_start();
session_start();

require("db.php");

if ( isset($_SESSION['user']) ){
	$userid = $_SESSION['user'];

	if ($_GET['notdone'] == 1 ){
			$sql_query = "select distinct * from items natural join owns where userid = '$userid' and done = '0' order by timecreated ASC";
		}
		else if ( !isset( $_GET['day'])){
			$sql_query = "select distinct * from items natural join owns where userid='$userid'  order by timedue DESC";
		}
		else if ($_GET['day'] == 0){
			$sql_query = "select distinct * from items natural join owns where userid='$userid' and timedue = CURRENT_DATE()  order by timecreated ASC";
			
		}
		
		else {
			$date = strtotime( $_GET['day'] );
			//$date =  $_GET['day'];
			mysql_real_escape_string($date);
			$sql_query = "select distinct * from items natural join owns where userid='$userid' and timedue =  FROM_UNIXTIME('$date','USA') order by timecreated ASC";
			
		}
		
		$result = mysql_query($sql_query);

}
else {
	header("location:login.php");
}




ob_end_flush();


?>

<html>
<head>
<title>view todo</title>
<script type="text/javascript" src="calendarDateInput.js"></script>

</head>

<body>
<?php 
echo "Hello $userid  ||"?>
<a href= "addToDoList.php"> New To Do Item</a>  ||  
<a href= "viewToDoList.php"> View To Do Item</a>  ||  
<a href= "viewToDoList.php?day=0"> View To Do Item for TODAY</a>  ||  
<a href= "viewToDoList.php?notdone=1"> View undone items</a>  ||  
<a href= "logout.php"> Log out of Account</a>  ||  <br/>
View items for another day
<form action='viewToDoList.php' method='get' name='viewaday'>
<script>DateInput('due', true, 'YYYY-MM-DD')</script>
<input type='submit' value='Show Items for this day'></form> 
<br/>
<?php
echo "<table border='1'>
			<tr>
			
			<th>Date due</th>
			<th>Item</th>
			<th>Notes</th>
			<th>done?</th>
			</tr>";

while($row = mysql_fetch_array($result))
{	$id = $row['itemid'];
	echo "<tr>";
	if ($row['hasduedate'] == 1){
		echo "<td>" . $row['timedue'] . "</td>";
	}
	else 
		echo "<td>" . "No due date" . "</td>";
	
	
	if ($row['done'] == 0){
		echo "<td width=100>" . $row['name'] . "</td>";
		echo "<td width= 400>" . $row['notes'] . "</td>";
		echo "<td>" . " 
		<form action='addToDoList.php' method='get' name='add'>
		<input type='hidden' name = 'itemid' value = '$id'>
		<input type='hidden' name = 'done' value = '1'>
		<input type='submit' value='Yes'></form></td>";
	}
	else{
		echo "<td width=100><strike>" . $row['name'] . "</strike></td>";
		echo "<td width= 400><strike>" . $row['notes'] . "</strike></td>";
		echo "<td>" . " 
		<form action='addToDoList.php' method='get' name='add'>
		<input type='hidden' name = 'itemid' value = '$id'>
		<input type='hidden' name = 'done' value = '0'>
		<input type='submit' value='No'></form></td>";
	}

	echo "</tr>";
}
echo "</table>";
?>
</body>

</html>

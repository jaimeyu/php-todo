<?php

ob_start();
session_start();

require("db.php");

if ( isset($_SESSION['user']) ){
	
	
	if(isset($_GET['name']) && isset($_GET['notes']) && isset($_GET['due'])){
	
		$userid = $_SESSION['user'];
		mysql_real_escape_string($userid);
		
		//$sql_query = "insert into owns (itemid,userid) values ( (SELECT MAX(itemid) FROM owns limit 1)+1, '$userid')";
		$sql_query = "insert into owns (userid) values ('$userid')";
		$result = mysql_query($sql_query);
		
		$sql_query = "select max(itemid)  from owns where userid='$userid'";
		$result = mysql_query($sql_query);
		$row = mysql_fetch_row($result);
		$itemid = $row[0];
		//echo "I found the itemid = $itemid with $userid";
		

		$name = $_GET['name'];
		$notes = $_GET['notes'];
		$due = $_GET['due'];
		
		
		if ($_GET['hasduedate'] == 1) { //checkbox, so it won' t be set if its not checked... right?
				$hasduedate = 1;
			}
			else
				$hasduedate = 0;
			
			
			//protect from sql injection -- can be written with a for loop to save coding space
			mysql_real_escape_string($name);
			mysql_real_escape_string($notes);
			mysql_real_escape_string($due);
			//echo "$name   $notes   ";
			//echo $due . " ";
			$due = strtotime( $due );
			//echo $due;
			$sql_query = "INSERT INTO `items` ( `itemid`, `timecreated`, `timedue`, `name`, `notes`, `hasduedate`) VALUES ( '$itemid', NOW(), FROM_UNIXTIME('$due'), '$name', '$notes', '$hasduedate')";
			$result = mysql_query($sql_query);
			header("location:viewToDoList.php");
		}
		
		else if ( isset($_GET['done']) && isset($_GET['itemid'])){
			$itemid = $_GET['itemid'];
			$done = $_GET['done'];
			mysql_real_escape_string($itemid);
			mysql_real_escape_string($done);
			if ( $done == 1){
				$sql_query = "update items set done = '1' where itemid = '$itemid'";
			}
			else{
				$sql_query = "update items set done = '0' where itemid = '$itemid'";
			}
			
			mysql_query($sql_query);
			header("location:viewToDoList.php");
				
			
		}
		else{
			//echo "Not enough data written";
		}
	}

else {
	header("location:login.php");
}
?>

<html>
<head>
<title>add todo</title>
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

<form action='addToDoList.php' method='get' name='add'>
Name: <input name='name' type='text' value='name' /> <br/>
Requires due date: <input name='hasduedate' type='checkbox' value=1 /><br/>

Date due:<script>DateInput('due', true, 'YYYY-MM-DD')</script>
<!-- Date Due: <input name='due' type='text' value='YYYY-MM-DD' />  
Notes: <input name='notes' type='text' col='200' row='400' value='Notes' /> 
-->
<textarea name="notes" cols=75 rows="10">
Notes...
</textarea> <br/>
<input type='submit' value='Add Item'></form>


</body>

</html>



<?php
	$username='webuser';
	$password='webpass123';
	$database='PETS';
	$name=$_POST['name'];
	$owner=$_POST['owner'];
	$birthday=date('Y-m-d', strtotime($_POST['birthday']));
	$mysqli=new mysqli('10.0.6.10', $username, $password, $database);
	$query="INSERT INTO cats (name, owner, birth) VALUES ('".$name."', '".$owner."', '".$birthday."')";
	$result=$mysqli->query($query) or die($mysqli->error.__LINE__);
	$query2="SELECT * from cats where name='".$name."'";
	$result2=$mysqli->query($query2) or die($mysqli->error.__LINE__);
	if ($result2->num_rows > 0) {
		while($row=$result2->fetch_assoc()) {
			echo $row['name']."s birthday is ".$row['birth']."</br>";
		}
	}
	else {
		echo 'no results';
	}
?>

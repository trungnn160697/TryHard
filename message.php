<?php
include 'haudeptrai.php';

if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['mss'])&&
	$_POST['fullname'] != '' &&
	$_POST['email'] != '' &&
	$_POST['mss'] != '') {
	$query = "INSERT INTO message (fullname, email, mss) VALUES (:fullname, :email, :mss)";
	$data = array(':fullname'	=> $_POST['fullname'],
					':email'	=> $_POST['email'],
					':mss'		=> $_POST['mss'] );
	try{
		getSQLData($query, $data);
		echo '1';
	}catch(PDOException $e){
		echo $e->getMessage();
	}
}else
	echo 0;
?>
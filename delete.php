<?php
include 'haudeptrai.php';
session_start();

if (currentUserIsAdmin()) {
	if (isset($_GET['mstl'])) {
		$query = 'DELETE FROM tailieu WHERE mstl = :mstl';
		$data = array(':mstl' => $_GET['mstl']);
		try{
			getSQLData($query, $data);
			echo '1';
		}catch(PDOException $e){
			echo  $e->getMessage();
		}
	}else
	if (isset($_GET['username']) && !currentUserIsAdmin($_GET['username'])) {
		$query = 'DELETE FROM _user WHERE username = :username';
		$data = array(':username' => $_GET['username']);
		try{
			getSQLData($query, $data);
			echo '1';
		}catch(PDOException $e){
			echo  $e->getMessage();
		}
	}else
	if (isset($_GET['id'])) {
		$query = 'DELETE FROM message WHERE id = :id';
		$data = array(':id' => $_GET['id']);
		try{
			getSQLData($query, $data);
			echo '1';
		}catch(PDOException $e){
			echo  $e->getMessage();
		}
	}
	else{
		echo '0';
	}
}else{
	echo '-1';
}

?>
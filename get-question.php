<?php
include 'haudeptrai.php';
session_start();
if (isset($_GET['mon'])) {
	$query = "SELECT * FROM question
				WHERE msmh = :mon
				ORDER BY random()
				LIMIT 50";
	$data = array(':mon' => $_GET['mon']);
	$questionData = getSQLdata($query, $data);
	echo json_encode($questionData);
}

?>
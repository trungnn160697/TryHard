<?php
include 'haudeptrai.php';

if (isset($_GET['mon'])) {
	$query1 = "SELECT count(_user.username) member_count
				FROM _user";
	$query2 = "SELECT sum(luottai) download_count
				FROM tailieu
				WHERE msmh = :mon";
	$query3 = "SELECT count(r.mstl) rate_count
				FROM rate r, tailieu t
				WHERE r.mstl = t.mstl AND msmh = :mon";
	$data	= array('mon' => $_GET['mon']);
	$member_count 	= getSQLData($query1)[0]['member_count'];
	$download_count = getSQLData($query2, $data)[0]['download_count'];
	$rate_count 	= getSQLData($query3, $data)[0]['rate_count'];
	$json_data = array(	'member_count' 	=> $member_count,
						'download_count'=> $download_count,
						'rate_count'	=> $rate_count );
	echo json_encode($json_data);					 
}
?>
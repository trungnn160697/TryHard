<?php
include 'haudeptrai.php';
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$db = getDbConnect();	
	$stmt = $db->prepare('SELECT tailieu.image, tentl, tenmh, hoten, ngaydang, luottai, rate, _user.username, mota
							FROM tailieu, monhoc, _user 
							WHERE monhoc.msmh = tailieu.msmh AND _user.username = tailieu.username AND mstl = :id');
	$data = array('id' => $id);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$stmt->execute($data);
	$resultSet = $stmt->fetchAll();

	// echo 	$resultSet[0]['image'] . "--(c^c)--" . $resultSet[0]['tentl'] . "--(c^c)--" . 
	// 		$resultSet[0]['tenmh'] . "--(c^c)--" . $resultSet[0]['hoten'] . "--(c^c)--". 
	// 		$resultSet[0]['ngaydang'] . "--(c^c)--" . $resultSet[0]['luottai'] . "--(c^c)--" .
	// 		$resultSet[0]['rate'] . "--(c^c)--" . $resultSet[0]['username'] . "--(c^c)--" . $resultSet[0]['mota'];
	$responseData = array(	'image' 		=> $resultSet[0]['image'],
							'tentailieu'	=> $resultSet[0]['tentl'],
							'mon' 			=> $resultSet[0]['tenmh'],
							'nguoidang'		=> $resultSet[0]['hoten'],
							'ngaydang'		=> reformatDate($resultSet[0]['ngaydang']),
							'luottai'		=> $resultSet[0]['luottai'],
							'rate'			=> $resultSet[0]['rate'],
							'username'		=> $resultSet[0]['username'],
							'mota'			=> $resultSet[0]['mota']); 
	$responseString = json_encode($responseData);
	echo $responseString;
}
?>
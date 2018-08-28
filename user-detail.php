<?php
include 'haudeptrai.php';
if(isset($_GET['id']) || isset($_GET['username'])){
	$id = isset($_GET['id'])?$_GET['id']:null;
	$user = isset($_GET['username'])?$_GET['username']:null;
	$db = getDbConnect();	
	$stmt = $db->prepare('SELECT username, hoten, ngaysinh, email, image, sotailieu
							FROM _user 
							WHERE username = :user OR user_id = :id');
	$data = array(	'user' => $user,
					'id' => $id	);

	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$stmt->execute($data);
	$resultSet = $stmt->fetchAll();

	$responseData = array(	'image' 		=> $resultSet[0]['image'],
							'username'		=> $resultSet[0]['username'],
							'fullname'		=> $resultSet[0]['hoten'],
							'ngaysinh'		=> reformatDate($resultSet[0]['ngaysinh']),
							'email'			=> $resultSet[0]['email'],
							'sotailieu'		=> $resultSet[0]['sotailieu']); 
	$responseString = json_encode($responseData);
	echo $responseString;
}
?>
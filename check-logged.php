<?php
include 'haudeptrai.php';
session_start();


if (isset($_GET['isadmin'])) {
	echo currentUserIsAdmin()?1:0;
	return;
}
if(isset($_SESSION['user'])){
	
	//Truong hop da dang nhap

	//Lay ten nguoi dung tu phien dang nhap
	$user = $_SESSION['user']; 
	
	// Lay thong tin nguoi dung tu CSDL thong qua 'user'
	$db = getDbConnect();	
	$stmt = $db->prepare('SELECT * FROM _user WHERE username = :username');
	$data = array('username' => $user);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$stmt->execute($data);
	$resultSet = $stmt->fetchAll();

	// echo $resultSet[0]['image'] . "--(c^c)--" . $resultSet[0]['hoten'] . "--(c^c)--" . 
	// 				$resultSet[0]['email'] . "--(c^c)--" . $resultSet[0]['ngaysinh'];
	$userData = array('image' =>  $resultSet[0]['image'],
						'fullName'	=> $resultSet[0]['hoten'],
						'email'		=> $resultSet[0]['email'],
						'birth'		=> $resultSet[0]['ngaysinh'],
						'user_id'	=> $resultSet[0]['user_id'],
						'username'	=> $resultSet[0]['username']);
	echo json_encode($userData);
}else{
	echo "not"; 
}


?>
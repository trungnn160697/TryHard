<?php
include 'haudeptrai.php';
session_start();


//Lay du lieu post len tu hop thoai dang nhap
$user 		= urldecode($_POST['username']);
$password	= hash('sha256', urldecode($_POST['password']));

//Tim kiem trong CSDL
//Khoi tao truy xuat CSDL, ham getDB() trong haudeptrai.php
$db = getDbConnect();

//Cau lenh truy van :user va :pass la cac bien giu cho.
$stmt = $db->prepare('SELECT * FROM _user WHERE username = :username AND password = :pass');

//Thay cac bien :user :pass bang gia tri gui tu form dang nhap
$data = array('username' => $user,
				'pass' => $password);

//Thiet lap che do lay ve tu CSDL: 
//tham so PDO::FETCH_ASSOC dung ten cot trong CDSL lam chi so cho mang tra ve
$stmt->setFetchMode(PDO::FETCH_ASSOC);

//Khoi chay cau lenh truy van
$stmt->execute($data);

//Lay ket qua truy van, ket qua tra ve tu truy van duoi dang mang 2 chieu
$resultSet = $stmt->fetchAll();

//Kieu tra so phan tu trong mang (tuong duong so ban ghi nhan duoc tu truy van)
if(count($resultSet) != 0){

	//Tim thay user va password khop
	//Khoi Tao phien lam viec
	$_SESSION['user'] = $user;
	if(isset($_POST['current_page'])){
		header('Location: ' . $_POST['current_page']);
	}else{
		//Chuyen huong ve trang chu
		header('Location: .');
	}
}else{
	//Khong khop user va password
	//Chuyen huong ve trang chu
	header('Location: index.php?action=login');
}

?>
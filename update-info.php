<?php
include 'haudeptrai.php';
session_start();
if(!isset($_SESSION['user'])){
	//Chuyen huong ve trang chu
	header('Location: index.php?action=login');
	exit();
}
if(isset($_POST['email']) ){
	$user 		= $_SESSION['user'];
	$password	= hash('sha256', urldecode($_POST['password']));
	$npass		= hash('sha256', urldecode($_POST['npass']));
	$email		= urldecode($_POST['email']);
	$name		= urldecode($_POST['fullName']);
	$ns 		= urldecode($_POST['birthday']);
	$user = strip_tags($user);
	$name = strip_tags($name);

	$imageLink = uploadImage();

	//In ra noi dung html cua trang chu
	echo file_get_contents('Home.html');

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		jsalert("Cập nhật thất bại. Định dạng email không hợp lệ!");
	  exit(); 
	}
	if(strtotime($ns) > time()){
		jsalert("Cập nhật thất bại. Ngày sinh không hợp lệ!");
		exit();
	}

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
		$stmt = $db->prepare("UPDATE _user SET hoten = :name, ngaysinh = :ns, password = :password, email = :email, image = :img WHERE username = :user ");
		//$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$data = array(	'user'		=> $user,
						'password'	=> $npass,
						'email'		=> $email,
						'name'		=> $name,
						'ns'		=> $ns,
						'img'		=> $imageLink);
		if($imageLink == ""){
			$stmt = $db->prepare("UPDATE _user SET hoten = :name, ngaysinh = :ns, password = :password, email = :email WHERE username = :user ");
			//$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$data = array(	'user'		=> $user,
							'password'	=> $npass,
							'email'		=> $email,
							'name'		=> $name,
							'ns'		=> $ns);
		}
		try {
			$stmt->execute($data);
			jsalertAndRedirect('Chúc mừng bạn cập nhật thành công với tài khoản: ' . $user, 'index.php');
		} catch (PDOException $e) {
			jsalertAndRedirect('Cập nhật thất bại. Cập nhật lỗi!', 'index.php');
			$e->getMessage() ;
		}
	}
	else{
		jsalertAndRedirect("Mật khẩu cũ không đúng!", 'index.php');
	}
}
?>
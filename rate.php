<?php
include 'haudeptrai.php';

session_start();
if (isset($_GET['query']) && isset($_GET['mstl'])) {
	# code...
	$db = getDbConnect();
	$query = $db->prepare('SELECT count(mstl) so_nguoi_danh_gia, avg(rate) danh_gia_trung_binh
							FROM rate
							WHERE mstl = :mstl');
	$data = array('mstl' => $_GET['mstl'] );
	try{
		$query->execute($data);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		echo  number_format($result[0]['danh_gia_trung_binh'], 1) . ', từ ' . $result[0]['so_nguoi_danh_gia'] . ' người dùng';
	}catch(PDOException $e){
		echo '';
	}
	$db = null;
	return;
}

if (isset($_SESSION['user']) && isset($_GET['mstl'])) {
	$db = getDbConnect();
	try{
		$query = $db->prepare('INSERT INTO rate (username, mstl, rate) VALUES (:user, :mstl, :rate)');
		$data = array('user' => $_SESSION['user'],
						'mstl' => $_GET['mstl'],
						'rate' => $_GET['rate'] );
		$query->execute($data);
		echo json_encode(array('status' => '200', 'content' => 'Bạn vừa đánh giá ' . $_GET['rate'] . ' sao cho tài liệu ' . getNameOfDocument($_GET['mstl']))); 
	}catch(PDOException $e){
		$query = $db->prepare('UPDATE rate SET rate = :rate WHERE username = :user AND mstl = :mstl');
		$data = array('user' => $_SESSION['user'],
						'mstl' => $_GET['mstl'],
						'rate' => $_GET['rate'] );
		$query->execute($data);
		echo json_encode(array('status' => '200', 
			'content' => 'Bạn vừa thay đổi đánh giá tài liệu ' .
					 getNameOfDocument($_GET['mstl']) . ' thành ' . $_GET['rate'] .' sao.' )); 
	}
	$query = $db->prepare('UPDATE tailieu
							SET rate = (
								SELECT avg(rate) AS total_rate
								FROM rate
								WHERE mstl = :mstl)	
							WHERE mstl = :mstl');
	$data = array('mstl' => $_GET['mstl']);
	$query->execute($data);
	$db = null;
	return;
}else{
	echo json_encode(array('status' => '401', 'content' => 'Bạn cần đăng nhập để có thể dùng chức năng này'));
}
?>



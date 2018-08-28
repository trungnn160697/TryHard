<?php
include 'haudeptrai.php';
session_start();


//In ra noi dung html cua trang chu
echo file_get_contents('Home.html');

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

	$disableAdmin = '';
	if (!currentUserIsAdmin()) {
		$disableAdmin = '$("ul.dropdown-menu li:eq(2)").hide();';
	}
	//Hien thi ho ten nguoi dung len trang chu, va an nut dang ki, dang nhap
	runJavaScript("$('#login').show();$('#log-sign').hide();" .
			"$('li.dropdown img').attr('src', 'avarta/" . $resultSet[0]['image'] . "' );" .			
			"$('.modal-header img').attr('src', 'avarta/" . $resultSet[0]['image'] . "' );" .
			"$('li.dropdown span').html('" . $resultSet[0]['hoten'] ."');" .
			"$('#formupdate input:eq(0)').val('" . $resultSet[0]['hoten'] . "');" . 
			"$('#formupdate input:eq(1)').val('" . $resultSet[0]['email'] . "');" . 
			"$('#formupdate input:eq(2)').val('" . $resultSet[0]['ngaysinh'] . "');" . $disableAdmin);
	//jsalert('logged');
}else{
	//Truong hop chua dang nhap
	//jsalert('yet');
	//An phan ten nguoi dung tren trang chu
	//$hide_user =  "document.getElementById('logged').innerHTML= '';";
	if(isset($_GET['action'])){
		//Truong hop vua dang nhap sai

		//Mo lai hop thoai dang nhap
		runJavaScript("$('.fa.fa-sign-in').click();");
	}else{
		//Truong hop truy cap trang chu binh thuong
		runJavaScript("$('#log-sign').show();");
		//runJavaScript($hide_user);
	}

}


?>
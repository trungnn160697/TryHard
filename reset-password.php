<?php

include 'haudeptrai.php';
session_start();
if(isset($_POST['submit'])){

	$email = $_POST['email'];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$conn = getDbConnect();
		    // Check to see if a user exists with this e-mail
	    $query = $conn->prepare('SELECT email FROM _user WHERE email = :email');
	    $query->bindParam(':email', $email);
	    $query->execute();
	    $userExists = $query->fetch(PDO::FETCH_ASSOC);
	   
	    if($userExists["email"]){
	    	$fuckcode = generateRandomString(64);
	    	$smt = $conn->prepare('INSERT INTO resetlink (email, link) VALUES (:email, :link)');
	    	$smt->bindParam(':email', $userExists['email']);
	    	$smt->bindParam(':link', $fuckcode);
	    	$smt->execute();
	        
	        $mailbody = "Xin chào<br>\n Bạn nhận được email này vì chúng tôi nhận được yêu cầu đặt lại mật khẩu,<br>\nNếu không phải bạn xin bỏ qua email này.<br>\nNếu bạn muốn đặt lại mật khẩu xin nhấn vào link bên dưới đây<br><br>\n\n<a href='http://localhost/doc-share-project/reset-password.php?code=" . $fuckcode. "'>http://localhost/doc-share-project/reset-password.php?code=$fuckcode</a>";
	       // mail($userExists["email"], "Password Reset", $mailbody, $headers);

			sendHtmlMail($userExists['email'], 'Đặt lại mật khẩu', $mailbody);
			 // if(!$mail->Send()) {
			 //   // echo "Mailer Error: " . $mail->ErrorInfo;
			 // } else {
			 //    //echo "Message has been sent";
			 // }
	       // echo "pass 3";
	    }
	    $conn = null;
	}
	if (isset($_POST['current_page'])) {
		jsalertAndRedirect('Email khôi phục mật khẩu đã được gửi!', $_POST['current_page']);
	}
	else
    	jsalertAndRedirect('Email khôi phục mật khẩu đã được gửi!', 'index.php');
}

if(isset($_GET['code'])){
	$newpassword = generateRandomString(7);
	$passwordencoded = hash('sha256', $newpassword);
	$db = getDbConnect();
		    // Check to see if a user exists with this e-mail
    $query = $db->prepare('SELECT email FROM resetlink WHERE link = :link');
    $query->bindParam(':link', $_GET['code']);
    $query->execute();
    $emailExists = $query->fetch(PDO::FETCH_ASSOC);
    if($emailExists["email"]){
		$stmt = $db->prepare("UPDATE _user SET password = :password WHERE email = :email ");
		//$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$data = array(	'password'	=> $passwordencoded,
						'email'		=> $emailExists["email"]);
		try {
			$stmt->execute($data);
			echo 'Mật khẩu của bạn được đặt lại thành: ' . $newpassword;

			$delquery = $db->prepare("DELETE FROM resetlink WHERE email = :email");
			$delquery->bindParam(':email', $emailExists["email"]);
			$delquery->execute();
		} catch (PDOException $e) {
			echo "Có lỗi xảy ra, vui lòng thực hiện lại sau.";
			//$e->getMessage() ;
		}
	}else{
		echo "Đường dẫn không tồn tại hoặc đã hết hiệu lực.";
	}
}







function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
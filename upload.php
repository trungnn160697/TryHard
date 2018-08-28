<?php
include 'haudeptrai.php';
session_start();
date_default_timezone_set('UTC');
if(!isset($_SESSION['user'])){
	//Chuyen huong ve trang chu
	header('Location: index.php?action=login');
	exit();
}

if(isset($_POST['submit'])){
	// var_dump($_POST);
	$mon = $_POST['monhoc'];
	$chude = $_POST['chude'];
	$ten =  strip_tags($_POST['doc-name']);
	$mota =  strip_tags($_POST['doc-info']);
	$imageLink = uploadDocImage();
	$fileLink = uploadDocFile();
	if($imageLink != "" && $fileLink != ""){

		$db = getDbConnect();
		//Cau lenh truy van :user va :pass la cac bien giu cho.
		$stmt = $db->prepare("INSERT INTO tailieu (msmh, username, machude, tentl, mota, ngaydang, luottai, link, image, rate, time, file_type) " .
								"VALUES (:msmh, :username, :chude, :ten, :mota, :today, 0, :link, :image, 0.0, current_date + current_time, :file_type)");

		//Thay cac bien :user :pass bang gia tri gui tu form dang nhap
		$data = array(	'msmh'     => $mon,
						'username' => $_SESSION['user'],
						'chude'    => $chude,
						'ten'      => $ten,
						'mota'     => $mota,
						'today'    => date('Y-m-d'),
						'link'     => $fileLink,
						'image'    => $imageLink,
                        'file_type' => $_SESSION['file_type']);

		//Thiet lap che do lay ve tu CSDL: 
		//tham so PDO::FETCH_ASSOC dung ten cot trong CDSL lam chi so cho mang tra ve
		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		try {
			$stmt->execute($data);
			
			//Update uploaded Document of user.
			$update_doc_count_of_user_query = $db->prepare("UPDATE _user SET sotailieu = sotailieu + 1 WHERE username = :username");
			$data1 = array('username' => $_SESSION['user'] );
			$update_doc_count_of_user_query->execute($data1);
			$db = null;
			jsalertAndRedirect('Chúc mừng bạn đăng thành công tài liệu: ' . $ten, 'index.php');
			//jsalert('Chúc mừng bạn đăng kí thành công với tài khoản: ' . $user);
		} catch (PDOException $e) {
			//jsalert('Đăng ký thất bại. Đăng ký lỗi!');
			jsalertAndRedirect('Đăng thất bại tài liệu: ' . $ten . $_SESSION['file_type'] .$e->getMessage() , 'index.php');
		}
	}
	// echo "<br>" . $imageLink;
	// echo "<br>" . $fileLink;
}


function uploadDocFile(){
	date_default_timezone_set('UTC');
    $ndate =  date('F-Y-h-i-s-A');
	$target_dir = "uploads\\";
    $target_file = $target_dir . urlencode (basename($_FILES["doc-file"]["name"])) . $ndate;
    $uploadOk = 1;
    $imageFileType = pathinfo('uploads\\' . urlencode (basename($_FILES["doc-file"]["name"])),PATHINFO_EXTENSION);
    $_SESSION['file_type'] = $imageFileType;
    // Check if file already exists
    if (file_exists($target_file)) {
       // echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    // if ($_FILES["doc-img"]["size"] > 500000) {
    //     jsalert("Sorry, your file is too large.");
    //     $uploadOk = 0;
    // }
    // Allow certain file formats
    if($imageFileType == "php" ) {
      //  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        return "";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["doc-file"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["doc-img"]["name"]). " has been uploaded.";
            return basename( urlencode ($_FILES["doc-file"]["name"])) . $ndate;
        } else {
            echo "Xin lỗi, xảy ra lỗi đăng file." .basename( urlencode ($_FILES["doc-file"]["name"])) . $ndate;
        }
    }
}
function uploadDocImage(){
    date_default_timezone_set('UTC');
    if (!isset($_FILES['doc-img']['name']) || $_FILES['doc-img']['name'] == '') {
        return $_POST['monhoc'] . '-default.jpg';
    }   
    $ndate =  date('F-Y-h-i-s-A');
	$target_dir = "uploads\\";
    $target_file = $target_dir . $ndate . urlencode (basename($_FILES["doc-img"]["name"]));
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["next"])) {
        $check = getimagesize($_FILES["doc-img"]["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
           // echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
       // echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["doc-img"]["size"] > 2000000) {
        jsalert("Sorry, your file is too large.");
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      //  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        return "";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["doc-img"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["doc-img"]["name"]). " has been uploaded.";
            return $ndate . urlencode (basename( $_FILES["doc-img"]["name"]));
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
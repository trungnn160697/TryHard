<?php
include 'haudeptrai.php';

session_start();
if (isset($_SESSION['user'])) {
	if(isset($_GET['mstl'])){
		$db = getDbConnect();
		
		try{
			$query = $db->prepare('UPDATE tailieu SET luottai = luottai + 1 WHERE mstl = :mstl');
			$data = array('mstl' => $_GET['mstl'] );
			$query->execute($data);

			$query = $db->prepare("SELECT tentl, link, file_type FROM tailieu WHERE mstl = :mstl");
			$query->setFetchMode(PDO::FETCH_ASSOC);
			$query->execute($data);
			$result = $query->fetchAll();

			if (count($result) > 0) {
				//Start download
				    // Get parameters
				    $file = $result[0]["link"]; // Decode URL-encoded string
				    $filepath = "uploads/" . $file;
				    
				    // Process download
				    if(file_exists($filepath)) {
				        header('Content-Description: File Transfer');
				        header('Content-Type: application/octet-stream');
				        header('Content-Disposition: attachment; filename="' . $result[0]['tentl'] . '.' . trim($result[0]['file_type']) . '"');
				        header('Expires: 0');
				        header('Cache-Control: must-revalidate');
				        header('Pragma: public');
				        header('Content-Length: ' . filesize($filepath));
				        flush(); // Flush system output buffer
				        readfile($filepath);
				        exit;
				    }
			}else{
				echo "Không có mã tài liệu này!";
			}
		} catch(PDOExecption $e){
			echo "Không có mã tài liệu này!";
		}
	} else{
		echo "Không có mã tài liệu này!";
	}
}else{
	echo "Bạn cần đăng nhập trước để tải tài liệu này!<br>阿呆か？予めログインしなさい！";
}

?>
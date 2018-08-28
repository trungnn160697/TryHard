<?php

define("DATABASE_URL", "pgsql:host=localhost;port=5432;dbname=tryhard");
define("DB_USER", "postgres");
define("DB_PASSWORD", "ngoctrung166");
function getDbConnect(){

	// Set options
	$options = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
	// Create a new PDO instanace
	try {
		$db = new PDO(DATABASE_URL, DB_USER, DB_PASSWORD, $options);
		return $db;
	}
	// Catch any errors
	catch (PDOException $e) {
		echo $e->getMessage();
		return NULL;
	}
}
function uploadImage(){
    date_default_timezone_set('UTC');
    $ndate =  date('F-Y-h-i-s-A');
	$target_dir = "avarta\\";
    $target_file = $target_dir . $ndate . urlencode (basename($_FILES["avarta"]["name"]));
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["next"])) {
        $check = getimagesize($_FILES["avarta"]["tmp_name"]);
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
    if ($_FILES["avarta"]["size"] > 2000000) {
        jsalert("Ảnh quá lớn.");
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
        if (move_uploaded_file($_FILES["avarta"]["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["avarta"]["name"]). " has been uploaded.";
            return $ndate . urlencode (basename( $_FILES["avarta"]["name"]));
        } else {
            echo "Rất tiếc đã có lỗi phát sinh.";
        }
    }
}

function runJavaScript($script)
{
    echo    "<script>" .
            $script .
            "</script>";
}

function  jsalert($content){
    runJavaScript("alert('". $content ."');");
}

function jsalertAndRedirect($content, $link){
    runJavaScript("alert('". $content ."');window.location.href='" . $link . "';");
}

function getNameOfDocument($mstl){
    $db = getDbConnect();
    $query = $db->prepare('SELECT tentl FROM tailieu WHERE mstl = :maso');
    $query->bindParam(':maso', $mstl);
    $query->execute();
    $resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
    if(isset($resultSet[0]['tentl']))
        return $resultSet[0]['tentl'];
    else
        return '';
}
function reformatDate($orDate)
{
    return date("d/m/Y", strtotime($orDate));
}

function getSQLData($prepareQuery, $prepareData = '')
{
    # code...
    $db = getDbConnect();
    $query = $db->prepare($prepareQuery);
    if ($prepareData == '') {
        $query->execute();
    }else{
        $query->execute($prepareData);
    }
    $resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
    $db = null;
    return $resultSet;
}

function currentUserIsAdmin($user = ''){
    //session_start();
    if ($user == '') {
        $user = $_SESSION['user'];
    }
    if (!isset($_SESSION['user'])) {
        return false;
    }
    $query = "SELECT * FROM _admin WHERE username = :user";
    $data = array(':user' => $user );

    if (count(getSQLData($query, $data)) > 0) {
        return true;
    }
    else
        return false;

}

function sendHtmlMail($to, $subject, $body, $from='BigtrymTeam+')
{
    $ch = curl_init();
    $post = array(  'to'        => $to,
                    'from'      => $from,
                    'subject'   => $subject,
                    'message'   => $body );
    curl_setopt($ch, CURLOPT_URL,"http://fackbook.besaba.com/mail/sendmail.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    // in real life you should use something like:
    // curl_setopt($ch, CURLOPT_POSTFIELDS, 
    //          http_build_query(array('postvar1' => 'value1')));

    // receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);
    return $server_output;
}

function getSearchKey($key =''){
    if (isset($_GET['q'])) {
      return $key. $_GET['q'];
    }
    else
      return ''; 
}
?>
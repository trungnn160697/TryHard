<?php
include 'haudeptrai.php';

if (isset($_GET['x'])) {

	$db = getDbConnect();

	if ($_GET['x'] == "member") {
		# code...
		$smt = $db->prepare('SELECT count(*) AS count FROM _user');
		$smt->execute();
    	$count = $smt->fetch(PDO::FETCH_ASSOC);
    	if($count["count"]){
    		echo $count["count"];
    	}else{
    		echo "0";
    	}
    	$db = null;
	}

	if ($_GET['x'] == "doc"){
		# code...
		$smt = $db->prepare('SELECT count(*) AS count FROM tailieu');
		$smt->execute();
    	$count = $smt->fetch(PDO::FETCH_ASSOC);
    	if($count["count"]){
    		echo $count["count"];
    	}else{
    		echo "0";
    	}
    	$db = null;
	}

	if ($_GET['x'] == "download") {
		# code...
		$smt = $db->prepare('SELECT sum(luottai) as count FROM tailieu');
		$smt->execute();
    	$count = $smt->fetch(PDO::FETCH_ASSOC);
    	if($count["count"]){
    		echo $count["count"];
    	}else{
    		echo "0";
    	}
    	$db = null;
	}

}
?>
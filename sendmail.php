<?php

include 'haudeptrai.php';
session_start();
if (isset($_POST['emailto']) && currentUserIsAdmin() ) {
	$server_output = sendHtmlMail($_POST['emailto'], $_POST['mailsubject'], $_POST['mailbody']);
	echo $server_output;
}else
	echo '-2';
?>

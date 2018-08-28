<?php
include 'haudeptrai.php';
$db = getDbConnect();
$query = $db->prepare("SELECT username, hoten, sotailieu FROM _user ORDER BY sotailieu DESC LIMIT 5");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $user) {
	echo "<p><a href='chitietnguoidung.html?username=" . $user['username'] . "' class='col-xs-8'>" . $user['hoten'] . "</a>" .
			"<span class='col-xs-4'>" . $user['sotailieu'] . " tài liệu</p>";
}
?>
<?php
include 'haudeptrai.php';


$db = getDbConnect();
$query = $db->prepare("SELECT mstl, tentl, rate, luottai FROM tailieu ORDER BY luottai DESC LIMIT 5");
$query->execute();
$docs = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($docs as $tailieu) {
	echo "<p class='col-xs-9'><a href='chitiettailieu.html?id=" . $tailieu['mstl'] ."'>" . $tailieu['tentl'] . "</a><br>" .
			"<span class='info-document'>Rate:" . $tailieu['rate'] .
			"</span><span style='margin-left: 20px' class='info-document'>Số lượt tải:" . $tailieu['luottai'] . "</span></p>" .
			"<hr style='clear: both;'>";
}
?>
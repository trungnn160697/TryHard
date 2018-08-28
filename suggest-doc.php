<?php
include 'haudeptrai.php';


$db = getDbConnect();
if (isset($_GET['mon'])) {
	$query = $db->prepare("SELECT mstl, tentl, rate FROM tailieu WHERE msmh = :mon ORDER BY rate DESC LIMIT 5");
	$data = array('mon' => $_GET['mon'] );
	$query->execute($data);
}else{
	$query = $db->prepare("SELECT mstl, tentl, rate FROM tailieu ORDER BY rate DESC LIMIT 5");
	$query->execute();
}
$docs = $query->fetchAll(PDO::FETCH_ASSOC);
foreach ($docs as $tailieu) {
	echo "<p><a href='chitiettailieu.html?id=" . $tailieu['mstl'] ."' class='col-xs-8'>" . $tailieu['tentl'] . "</a>" .
			"<span class='col-xs-4'>Rate: " . $tailieu['rate'] . "</p>";
}
?>
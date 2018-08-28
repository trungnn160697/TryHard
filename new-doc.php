<?php
include 'haudeptrai.php';

$db = getDbConnect();
if (isset($_GET['mon'])) {
	$query = $db->prepare('SELECT mstl, tentl, ngaydang FROM tailieu WHERE msmh = :mon ORDER BY time DESC LIMIT 5');
	$data = array('mon' => $_GET['mon'] );
	$query->execute($data);
}else{
	$query = $db->prepare('SELECT mstl, tentl, ngaydang FROM tailieu ORDER BY time DESC LIMIT 5');
	$query->execute();
}
$new_docs = $query->fetchAll(PDO::FETCH_ASSOC);
// echo count($new_docs);
foreach ($new_docs as $doc) {
	if (isset($_GET['right']))
		echo "<p><a href='chitiettailieu.html?id=" . $doc['mstl'] ."' class='col-xs-7'>" . $doc['tentl'] . "</a>" .
			"<span class='col-xs-5'>" . reformatDate($doc['ngaydang']) . "</p>";
	else
		echo "<p class='col-xs-12'><a href='chitiettailieu.html?id=" . $doc['mstl'] ."'>" . $doc["tentl"] . "</a><br>" .
			"<span class='info-document'>" . reformatDate($doc["ngaydang"]) . "</span></p><hr style='clear: both;'>" ;
}
?>
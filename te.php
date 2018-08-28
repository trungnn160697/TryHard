<?php
include 'haudeptrai.php';

$db = getDbConnect();
$stmt = $db->prepare("SELECT * FROM test");
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();


$resultSet = $stmt->fetchAll();

echo '<table border="1" ><tr><th>USER</th><th>PASSWORD</th></tr>';
foreach ($resultSet as $row) {
	echo '<tr>'.
	'<td>' . $row['id']		. '</td>'.
	'<td>' . $row['name']	. '</td></tr>';
}
echo '</table>';

echo '<br><br><hr><br>';
?>
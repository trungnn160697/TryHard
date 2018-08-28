<?php
$dsn = 'mysql:host=localhost;dbname=u729339732_mydb';
// Set options
$options = array(
PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
// Create a new PDO instanace
try {
	$db = new PDO($dsn, 'u729339732_hajau', '12345678', $options);
}
// Catch any errors
catch (PDOException $e) {
	echo $e->getMessage();
	exit();
}

$stmt = $db->prepare('INSERT INTO account (user, password, email, name, ngaysinh, gioitinh) 
						VALUES (:user, :password, :email, :name, :ns, :gt)');
//$stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$data = array(	'user'		=> 'hajaulee',
				'password'	=> 'Fucjyoubaby',
				'email'		=> 'leconghau.hit@gmail.com',
				'name'		=> 'Hậu đẹp trai',
				'ns'	=> '1999-11-11',
				'gt'	=> 'nam' );
try {
	$stmt->execute($data);
} catch (PDOException $e) {
	echo 'Can not insert to database<br>';
}



/* 

Truy van du lieu

*/

$stmt = $db->prepare('SELECT * FROM account');
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();


$resultSet = $stmt->fetchAll();

echo '<table border="1" ><tr><th>USER</th><th>PASSWORD</th><th>EMAIL</th><th>NAME</th><th>BIRTH</th><th>SEX</th></tr>';
foreach ($resultSet as $row) {
	echo '<tr>'.
	'<td>' . $row['user']		. '</td>'.
	'<td>' . $row['password']	. '</td>'.
	'<td>' . $row['email'] 		. '</td>'.
	'<td>' . $row['name'] 		. '</td>'.
	'<td>' . $row['ngaysinh'] 	. '</td>'.
	'<td>' . $row['gioitinh'] 	. '</td></tr>';
}
echo '</table>';

echo '<br><br><hr><br>';

$stmt = $db->prepare('SELECT * FROM account WHERE user = :user');
$data = array('user' => 'ncurses' );
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute($data);
$resultSet = $stmt->fetchAll();


echo '<table border="1" ><tr><th>USER</th><th>PASSWORD</th><th>EMAIL</th><th>NAME</th><th>BIRTH</th><th>SEX</th></tr>';
foreach ($resultSet as $row) {
	echo '<tr>'.
	'<td>' . $row['user']		. '</td>'.
	'<td>' . $row['password']	. '</td>'.
	'<td>' . $row['email'] 		. '</td>'.
	'<td>' . $row['name'] 		. '</td>'.
	'<td>' . $row['ngaysinh'] 	. '</td>'.
	'<td>' . $row['gioitinh'] 	. '</td></tr>';
}
echo '</table>';
?>
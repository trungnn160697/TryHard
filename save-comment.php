<?php
include 'haudeptrai.php';
session_start();

// var_dump($_POST);
if (isset($_SESSION['user'])) {
	$db = getDbConnect();
	try{
		// insert user into table of users commented
		$query = $db->prepare('INSERT INTO user_comment (user_id, mstl)
								(SELECT user_id, :mstl 
								 	FROM _user WHERE username = :user)');
		$data = array(	'mstl'	=> $_GET['mstl'],
						'user'	=> $_SESSION['user'] );
		$query->execute($data);
	} catch(PDOException $e){}

	$flag = true;
	while($flag){
		try{
			$query = $db->prepare('INSERT INTO comment_content (mstl, parent, created, modified, content, ping, upvote_count, creator)
									(SELECT :mstl, :parent, :created, :modified, :content, :pings, :upvote_count, user_id
									FROM _user WHERE username = :user)');
			$data = array(	'mstl'		=> $_GET['mstl'],
							'parent'	=> intval($_POST['parent']) == 0?null:intval($_POST['parent']),
							'created'	=> $_POST['created'],
							'modified'	=> $_POST['modified'],
							'content'	=> $_POST['content'],
							'pings'		=> isset($_POST['pings'])?arrayToString($_POST['pings']):null,
							'upvote_count' => $_POST['upvote_count'],
							'user'		=> $_SESSION['user'] );
			$query->execute($data);
			$getLastIdQuery = $db->prepare('SELECT currval(\'comment_id_seq\') AS lastest_id ');
			$getLastIdQuery->execute();
			$resultSet = $getLastIdQuery->fetchAll(PDO::FETCH_ASSOC);
			echo $resultSet[0]['lastest_id'];
			$flag = false;
		}catch(PDOException $e){
			//echo $e->getMessage();
		}
	}

}
else
{
	echo 0;
}


function arrayToString($a)
{
	return implode(',', $a);
}
?>
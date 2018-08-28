<?php
include 'haudeptrai.php';
if (isset($_GET['mstl']) && isset($_GET['usercomment'])) {
	$db = getDbConnect();
	$query = $db->prepare('SELECT c.user_id id, hoten fullname, email, concat(\'avarta/\',image) profile_picture_url
							FROM user_comment c, _user u
							WHERE c.user_id = u.user_id AND c.mstl = :mstl');
	$data = array('mstl' =>$_GET['mstl'] );
	$query->execute($data);
	$resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($resultSet);
	$db = null;
	return;
}
if (isset($_GET['mstl']) && isset($_GET['commentcontent'])) {
	$db = getDbConnect();
	$query = $db->prepare('SELECT id, parent, trim(created) created, trim(modified) as modified, content, concat(\'[\', ping, \']\') as pings, 
								creator,hoten as fullname,concat(\'avarta/\', image) as profile_picture_url,
								false as created_by_admin, false as created_by_current_user, upvote_count,
								false user_has_upvoted, false as is_new
							FROM comment_content, _user
							WHERE mstl = :mstl AND creator = user_id ORDER BY id, parent');

	$data = array('mstl' =>$_GET['mstl'] );
	$query->execute($data);
	$resultSet = $query->fetchAll(PDO::FETCH_ASSOC);
	$responText = json_encode($resultSet);
	echo str_replace(['"[', ']"'], ['[', ']'], $responText) ;
	$db = null;
	return;
}
?>
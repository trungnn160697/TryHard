<?php
include 'haudeptrai.php';
if (isset($_GET['mon']) && isset($_GET['chude'])) {
	if (isset($_GET['page'])) {
		//echo "1<br>";
		$docCountInOnePage = 6;
		$maxPageCountInOneSection = 3;

		$page = intval($_GET['page']);
		if ($page == 0) {
			$page = 1;
		}
		$getDocCountQuery = "SELECT count(mstl) as count FROM tailieu WHERE msmh = :mon AND machude = :chude ";
		$data = array(	'mon'	=> $_GET['mon'],
						'chude'	=> $_GET['chude'] );
		$docCountSet = getSQLData($getDocCountQuery, $data);
		$totalDocCount = intval($docCountSet[0]['count']);

		// Tính page đầu đầu của section chứa page hiện tại
		$firstPageOfSection = $page - (($page - 1) % $maxPageCountInOneSection);
		$pageCountOfSection = $maxPageCountInOneSection;

		while (($firstPageOfSection + $pageCountOfSection - 2) * $docCountInOnePage >= $totalDocCount)
			$pageCountOfSection--;
		$sectionInfo = array(	'maxPageCountInOneSection' => $maxPageCountInOneSection,
								'firstPageOfSection' => $firstPageOfSection,
								'pageCountOfSection' => $pageCountOfSection,
								'isLastSection' 	 => ($firstPageOfSection + $maxPageCountInOneSection -1) * $docCountInOnePage >= $totalDocCount);

		

		$query = 	'SELECT tentl, image, to_char(ngaydang, \'dd/mm/yyyy\') AS ngaydang, tailieu.mstl, mota, luottai, count(id) as comment_count
					FROM tailieu
					LEFT OUTER JOIN comment_content ON tailieu.mstl = comment_content.mstl
					WHERE msmh = :mon and machude = :chude
					GROUP BY (tailieu.mstl)
					LIMIT :limit_count OFFSET :off_set';
		$data1 = array(	':mon'	=> $_GET['mon'],
						':chude'	=> $_GET['chude'],
						':limit_count' => intval($docCountInOnePage),
						':off_set'	=> ($page - 1) * $docCountInOnePage );
		$resultSet = getSQLData($query, $data1);

		$responseData = array(	'info' 	=> $sectionInfo,
								'data'	=> $resultSet );
		echo json_encode($responseData);
		return;			
	}else{
		$query = 	'SELECT tentl, image, to_char(ngaydang, \'dd/mm/yyyy\') AS ngaydang, tailieu.mstl, mota, luottai, count(id) as comment_count
					FROM tailieu
					LEFT OUTER JOIN comment_content ON tailieu.mstl = comment_content.mstl
					WHERE msmh = :mon and machude = :chude
					GROUP BY (tailieu.mstl)
					LIMIT 4';
		$data = array(	'mon'	=> $_GET['mon'],
						'chude'	=> $_GET['chude'] );
		$resultSet = getSQLData($query, $data);
		echo json_encode($resultSet);			
	}
	
}


?>
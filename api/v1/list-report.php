<?php
require_once("../core/bootstrap.php");

global $db;
global $_JSON;

$limit = 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = '%' . $search . '%';
$page = isset($_GET['page']) ? intval($_GET['page']) : 0;
$userId = isset($_SESSION[APP_SESSION_USER_ID]) ? $_SESSION[APP_SESSION_USER_ID] : null;

try {

	$start = $page * $limit;

	$stmt = $db->prepare(
		"SELECT reports.id, reports.address, reports.photo, reports.user_id, reports.created_at, reports.cache_votes as votes, users.name as user_name FROM reports JOIN users ON (users.id = reports.user_id) WHERE reports.cache_votes > -10 AND address LIKE ? ORDER BY created_at DESC LIMIT ?, ?"
	);
	$stmt->bindParam(1, $search);
	$stmt->bindParam(2, $start, PDO::PARAM_INT);
	$stmt->bindParam(3, $limit, PDO::PARAM_INT);
	$stmt->execute();

	$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$stmt = $db->prepare(
		"SELECT COUNT(*) as count FROM reports WHERE reports.cache_votes > -10 AND address LIKE ? ORDER BY created_at"
	);
	$stmt->bindParam(1, $search);
	$stmt->execute();

	$count = $stmt->fetchColumn(0);

	if (count($reports) <= 0) {
		http_response_code(200);
		echo json_encode(
			[
				'reports' => [],
				'total' => 0,
				'limit' => $limit
			]
		);
		exit;
	}

	$reportIds = array_map(
		function ($report) {
			return $report['id'];
		},
		$reports
	);

	$reportIdsPlaceholder = str_repeat("?,", count($reportIds) - 1) . "?";

	$stmt = $db->prepare(
		"SELECT report_id, type FROM report_votes WHERE user_id = ? AND report_id IN ($reportIdsPlaceholder)"
	);
	$stmt->bindParam(1, $userId);
	for ($i = 0; $i < count($reportIds); $i++) {
		$stmt->bindParam(2 + $i, $reportIds[$i]);
	}
	$stmt->execute();
	$myVotes = $stmt->fetchAll();

	$reports = array_map(
		function ($report) use ($myVotes) {
			$myVote = array_filter(
				$myVotes,
				function ($vote) use ($report) {
					return $vote['report_id'] === $report['id'];
				}
			);
			if (count($myVote) === 1) {
				$report['my_vote'] = array_shift($myVote)['type'];
			}

			return $report;
		},
		$reports
	);

	http_response_code(201);
	echo json_encode(
		[
			'reports' => $reports,
			'total' => $count,
			'limit' => $limit
		]
	);

} catch (Exception $ex) {
	http_response_code(500);
	echo json_encode(
		[
			'error' => $ex->getMessage()
		]
	);
}

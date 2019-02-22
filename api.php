<?php
require_once './libs/autoload.php';
$_get = $_GET;
if (isset($_get['type']) || empty($_get['type'])) {
	
}

if (isset($_get['key']) || empty($_get['key'])) {
	
}
$type = strtolower($_get['type']);
$key = strtolower($_get['key']);

$ret = null;
switch ($key) {
	case 'phone':
		$ret = app\QueryPhone::query($_get['val']);
		break;
}

echo json_encode(['code' => 1, 'msg' => 'ok', 'data' => $ret]);
 
?>

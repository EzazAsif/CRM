<?php
$view = isset($_GET['view']) ? $_GET['view'] : 'index';
switch ($view) {
	case 'category':
		include(base_app.'admin/services/category.php');
		break;
	case 'services':
		include(base_app.'admin/services/service_list.php');
		break;
	case 'todocalender':
		include(base_app.'admin/todo_calender/calender.html');
		break;
	default:
		include(base_app.'admin/services/service_list.php');
		break;
}
?>
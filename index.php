<html>

	<head>

		<meta charset="UTF-8">
<!--		<title>  </title>-->
		<link rel="stylesheet" href="resources/css/basic.css">

	</head>

	<body>

<?php

header('content-type: text/html;charset=utf-8');

require_once 'core/config.php';
require_once PROJECT_PATH . 'core/utils.php';
require_once PROJECT_PATH . 'core/defines.php';

echo '<a href="test.php" target="_blank">Test Battle</a><hr/><br/>';

require_once PROJECT_PATH . 'modules/action/action_list.php';

echo "isso é um teste";
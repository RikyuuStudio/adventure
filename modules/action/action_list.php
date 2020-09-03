<?php

require_once PROJECT_PATH . 'modules/action/ActionDAO.class.php';
require_once PROJECT_PATH . 'classes/DAO.class.php';



$dao = new DAO();

$test = $dao->getInfo( 'action');


dd( $test);

echo '<table style="background-color: lightgray; border: solid 1px gray; font-family: Verdana; font-size: 12px"><tr>';

foreach ( $listHeaders as $header ) {
	
	echo '<th>' . strtoupper( $header ) . '</th>';
	
}

echo '</tr>';

foreach ($list as $row ) {
	
	echo '<tr>';
	
	foreach ( $row as $cell ) {
		
		echo '<td style="background-color:white; border: solid 1px gray">' . $cell . '</td>';
		
	}
	
	echo '</tr>';
	
}

echo '</table>';
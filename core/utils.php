<?php

	function d( ...$args ) {

		foreach( $args as $arg ) {

			echo '<div><pre style="text-align: left"> ', var_dump($arg), '</pre></div>';

		}

	}

	function dd( ...$args ) {

		foreach( $args as $arg ) {

			echo '<div><pre style="text-align: left"> ', var_dump($arg), '</pre></div>';

		}

		die();

	}

	// String Functions

	function textLimiter($text,$limit){

		if (strlen($text) > $limit) {
	
			return substr($text, 0, $limit).'...';
	
		} else {
	
			return substr($text, 0, $limit);
	
		}

	}

?>
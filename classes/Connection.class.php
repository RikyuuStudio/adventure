<?php

require_once PROJECT_PATH . 'core/config.php';
require_once PROJECT_PATH . 'core/defines.php';
require_once PROJECT_PATH . 'classes/Statement.class.php';

class Connection extends PDO {

	private static $instance = null;


	public function __construct( $dsn, $user, $pass ) {

		parent::__construct( $dsn, $user, $pass );
		
		$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('Statement', array($this)));
		
	}


	public static function getInstance() {

		if ( !isset( self::$instance ) ) {

			try {

				self::$instance = new Connection( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS );

			} catch( PDOException $exception ) {

				throw new Exception( $exception);



			}

		}

		return self::$instance;

	}

}
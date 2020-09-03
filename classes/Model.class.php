<?php

require_once PROJECT_PATH . 'classes/DAO.class.php';

class Model {

	private $className;
	
	private $property = array();
	
	
	public function __construct( $className, $id = null ) {
		
		$this->className = $className;
		
		$dao = new DAO();
		
		$search = $dao->select(
			'information_schema.columns',
			"table_name = '" . $this->className ."'",
			'column_name, data_type' );
		
		$columns = $search->fetchAll(PDO::FETCH_KEY_PAIR);
		
		foreach ( $columns as $column ) {

			switch ( $column ) {

				case 'int':
					$this->property[ key( $columns ) ] = 0;
					break;

				default:
					$this->property[ key( $columns ) ] = '';
					break;

			}

			next( $columns );
			
		}

		if ( ! is_null( $id ) && is_int( $id ) ) {

			$data = $dao->select( $this->className, 'id = ' . $id );
			
			$row = $data->fetch( PDO::FETCH_NAMED);
			
			if ( $row )
				$this->property = $row;

		}
		
	}
	
	
	public function read() {

		$dao = new DAO();
		
		return $dao->select( $this->className );

	}

	public function show() {

		$dao = new DAO();

		return $dao->select( 'INFORMATION_SCHEMA.COLUMNS', "TABLE_NAME = 'action'", 'COLUMN_NAME');

	}
	
}
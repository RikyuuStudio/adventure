<?php

require_once PROJECT_PATH . 'classes/Connection.class.php';

class DAO {
	
	protected $connection = null;
	
	
	public function __construct() {

		$this->connection = Connection::getInstance();
		
	}

	public function getInfo( string $tableName, string $columnName = null ) {

		$sql = "select column_name, column_default, is_nullable, data_type, character_maximum_length from information_schema.columns where table_name = '" . $tableName . "'";

		$command = $this->connection->query( $sql );

		$result = $command->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_NAMED );

		return $result;

	}
	
	
	/**
	 * @param $sql string
	 * @param $fecthStyle int
	 * @return array
	 */
	public function selectFull( $sql, $fecthStyle = PDO::FETCH_UNIQUE | PDO::FETCH_NAMED ): array {
	
		$command = $this->connection->query( $sql );
		
		$result = $command->fetchAll( $fecthStyle );
		
		return $result;
	
	}
	
	
	/**
	 * @param $table string
	 * @return array
	 */
	function list( $table ) {
		
		$sql = 'select * from ' . $table;
		
		$command = $this->connection->query( $sql );
		
		$list = $command->fetchAll( PDO::FETCH_NAMED );
		
		return $list;

	}
	
	function listHeaders( $tables ) {
		
		$sql = 'select column_name from information_schema.columns where table_name = :tables';
		
		$command = $this->connection->prepare( $sql );
		$command->bindParam(':tables', $tables);
		$command->execute();
		
		$list = $command->fetchAll(PDO::FETCH_COLUMN );
		
		return $list;
		
	}
	

	public function insert( $table, $columns, $values ){
		
		try {

			$query = "insert :table ( :columns, created_at ) values ( :values, now() )";

			$command = $this->connection->prepare( $query );
			
			$command->bindParam( ":table", $table, PDO::PARAM_STR);
			$command->bindParam( ":columns", $columns, PDO::PARAM_STR);
			$command->bindParam( ":values", $values, PDO::PARAM_STR);

			//dd($treta, $query, $table, $columns,$values, $command);

			$command->execute();
			
		} catch ( PDOException $exception) {
			
			$error = "Erro ao Cadastrar: " . $exception->getMessage();
			
			return $error;
			
		}
		
	}
	
	public function selectOLD( $tables, $clause = null, $columns = '*', $order = null ) {

		$query = 'select ' . $columns . ' from '  . $tables;

		if ( $clause != null )
			$query = $query . ' where ' . $clause;

		if ( $order != null )
			$query = $query . ' order by ' . $order;

		$command = $this->connection->prepare( $query );
		$command->execute();

		return $command;

	}
	
	//-------------------------------------------------------------------------------------------
	
	
	
	public function show( $table ) {
	
		$query = 'show columns from '  . $table;

		$command = $this->connection->prepare( $query);
		$command->execute();

		return $command;
	
	}


	public function validate ( $query ) {

		if ( $query->rowCount() == 0 )
			return true;

	}


	public function update( $table, $columns, $values ){

		try {

			$command = $this->db->prepare(
				'update ' . $table . ' ( ' . $columns . ", created_at ) values ( '" . $values . "', NOW() )"
			);
			$command->execute();

		} catch ( PDOException $exception) {

			$error = "Erro ao Atualizar: " . $exception->getMessage();

			return $error;

		}

	}


	public function delete( $table, $clause = null ) {

		try {

			$query = 'delete from ' . $table;

			if ( $clause != null )
				$query = $query . ' where ' . $clause;

			$command = $this->db->prepare( $query );
			$command->execute();

		} catch ( PDOException $exception ) {

			$error = "Erro ao Excluir: " . $exception->getMessage();

			return $error;

		}

	}
	
}
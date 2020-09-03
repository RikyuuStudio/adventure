<?php
/**
 * Statement
 * Classe de abstra��o para itera��es com o banco de dados
 * Faz o Override de alguns m�todos para padroniza��o de nomenclatura
 * @author	Leonardo Leal da Rosa	( leonardoldr@hotmail.com )
 * @version	$REVISION$
 * @uses	PDOStatement
 */

class Statement extends PDOStatement {
	
	/**
	 * Lista de parâmetros e valores adicionados a query
	 * @var $params array
	 * @acess Private
	 */
	private $params;
	
	/**
	 * Statement constructor.
	 */
	private function __construct() {}
	
	/**
	 * Retorna a query atual
	 * @return string
	 */
 	public function getSql() {
 		
 		return rtrim($this->queryString);
 		
 	}
 	
 	/**
 	 * Retorna os parâmetros atuais para Debug
 	 * @return array
 	 */
 	public function getParams() {
 		
 		return $this->params;
 		
 	}
 	
	/**
	 * Retorna o n�mero de linhas no statement atual
	 * @return integer
	 */
	public function recordCount() {
		
		return $this->rowCount();
		
	}
	
	/**
	 * Retorna a linha atual no formato associativo e num�rico
	 * @return array
	 */
	public function fetchBoth() {
		
		return $this->fetchUp( PDO::FETCH_BOTH );
		
	}
	
	/**
	 * Retorna a linha atual no formato associativo
	 * @return array
	 */
	public function fetchAssoc() {
		
		return $this->fetchUp( PDO::FETCH_ASSOC );
		
	}
	
	/**
	 * Retorna a linha atual no formato num�rico
	 * @return array
	 */
	public function fetchRow() {
		
		return $this->fetchUp( PDO::FETCH_NUM );
		
	}
	
	/**
	 * Retorna a linha atual no formato desejado
	 * @param $fetchMode int
	 * @return array
	 */
	public function fetchUp( $fetchMode = FETCH_BOTH ) {
		
		return parent::fetch( $fetchMode );
		
	}
	
	/**
	 * Retorna todas as linhas no formato desejado
	 * @param $fetchMode int
	 * @return array
	 */
	public function fetchAllUp( $fetchMode = FETCH_BOTH ) {
		
		return parent::fetchAll( $fetchMode );
		
	}
	
	/**
	 * Adiciona um parâmetro a query atual
	 * @param $name string
	 * @param $value mixed
	 * @throws Exception
	 */
 	public function bind( $name, $value ) {
 		
 		// Adiciona o parâmetro na lista de controle
 		if ( is_array( $value ) )
 			$value = @implode( ",", $value );
 		
 		$this->params[ $name ] = $value;
 		
 		// Setar para Nulo uma string vazia
 		if( trim( $value ) == '' )
 			$value = Null;
 		
 		// Nome não é uma posição Integer, adiciona os ":"
 		if ( !is_int( $name ) )
 			$name = ":{$name}";
 		
 		// Tipo de parâmetro a ser adicionado
 		switch( gettype( $value ) ) {
 			
 			case 'boolean': $type = PDO::PARAM_BOOL; break;
 			
 			case 'integer': $type = PDO::PARAM_INT; break;
 			
 			case 'double':  $type = PDO::PARAM_INT; break;
 			
 			case 'null':	$type = PDO::PARAM_NULL; break;
 			
 			case 'array': throw new Exception('O parâmetro "'.$name.'" não pode ser do tipo Array!', $this);

 			case 'object': throw new Exception('O parâmetro "'.$name.'" não pode ser do tipo Objeto!', $this);

 			case 'resource': throw new Exception('O parâmetro "'.$name.'" não pode ser do tipo Resource!', $this);
 			
 			// Trata como string qualquer outro
 			default: $type = PDO::PARAM_STR; break;
 		}
 		
 		// Faz o Bind
 		try {
 			
 			$this->bindParam( $name, $value, $type );
 			
		} catch( Exception $e ) {
 		
			throw new Exception($e->getMessage(), $this);
			
		}
		
 	}
 	
}
<?php
	
class Dice {
	
	private static $resultSet = array();
	private static $result;
	
	/***********
	 * GETTERS *
	 ***********/
	
	static function getResultSet() :array {
	
		return self::$resultSet;
	
	}
	
	static function getResult() :int {
		
		return self::$result;
		
	}
	
	
	/**
	 * @param int $faces
	 * @param int $quantity
	 * @return int
	 */
	static function roll( $faces = 6, $quantity = 1 ) :int {

		self::$resultSet = array();

		for ( $i = 1; $i <= $quantity; $i++ ) {

			$dieResult = rand( 1, $faces );
			
			self::$resultSet[ $i ] = $dieResult;

		}
		
		self::$result = array_sum( self::$resultSet);

		return self::$result;
	
	}

}
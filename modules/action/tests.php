<?php

require_once PROJECT_PATH . 'classes/Model.class.php';
require_once PROJECT_PATH . 'classes/DAO.class.php';

	$model = new Model('action', 1 );

	dd( $model);


//	O código a seguir pega a tabela action do banco de dados e baixa
//	cada linha como um array de índice COLUNA e valor CÉLULA
	
	$emTerraDeCegoQuemTemUmOlhoArray = array();

	$dao = new DAO();

	$search = $dao->select( 'action' );

	$result = $search->fetchAll(PDO::FETCH_NAMED);

	foreach ( $result as $row ) {

		$emTerraDeCegoQuemTemUmOlhoArray[ $row['id'] ] = $row;

		next( $result);

	}

	dd( $emTerraDeCegoQuemTemUmOlhoArray);

	//	O código a seguir pega a tabela action do banco de dados e baixa
	//	um array de arrays, no qual cada posição traz outras seis, com informações
	//  de cada coluna, como nome, tipo de dado e se pode ser null.

	$emTerraDeCegoQuemTemUmOlhoArray = array();

	$search = $dao->select( 'information_schema.columns', "table_name = 'action'", 'column_name, ordinal_position, column_default, is_nullable, data_type, character_maximum_length' );

	$result = $search->fetchAll(PDO::FETCH_NAMED);

	dd( $result);

	foreach ( $result as $row ) {

		$index = key( $result );

		$emTerraDeCegoQuemTemUmOlhoArray[ ++$index ] = $row;

		next( $result);

	}

	dd( $emTerraDeCegoQuemTemUmOlhoArray );

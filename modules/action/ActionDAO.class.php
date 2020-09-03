<?php

require_once PROJECT_PATH . 'classes/DAO.class.php';
require_once PROJECT_PATH . 'classes/Action.class.php';


class ActionDAO extends DAO {
	
	public function getActions() {
	
		return parent::list( 'action' );
	
	}

    public function getActionById( $id ):array {
    	
            $sql = 'SELECT * FROM action WHERE id = :id';
            
            $command = $this->connection->prepare( $sql );
            $command->bindParam(":id", $id);
            $command->execute();
            
            return $command->fetch( PDO::FETCH_NAMED );
            
    }
    
    public function action( $row ) {
    
    	$action = new Action();
    
    }
	
}
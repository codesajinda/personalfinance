<?php
require_once($_SESSION['documentRoot'] . '/DALManager/SqlConnector.php');

class DataAccess extends SqlConnector{
		
	protected $queryAndParams;
	private $sqlConnector;
	private $connection;

	public function __construct(){

	}

	protected function Connect(){		
		$this->sqlConnector = new SqlConnector();		
		$this->connection = $this->sqlConnector->Connect();	
		return $this->connection;
	}

	protected function ExecuteQuery(){		
		$this->sqlConnector = new SqlConnector();		
		$this->connection = $this->sqlConnector->Connect();	
		$result = null;		
		$sql = $this->queryAndParams;
		$result = $this->connection->query($sql);
		$this->connection->Close();
		return $result;
	}
	
}
?>
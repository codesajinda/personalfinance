<?php
class SqlConnector{
	private $servername = "localhost";
	private $username = "pfuser";
	private $password = "pfpassword";
	private $database = "pf";
	private $connection;

	public function __construct(){}

	protected function Connect(){
		// Create connection
		$this->connection = new mysqli($this->servername, $this->username, $this->password, $this->database);
		// Check connection
		if ($this->connection->connect_error) {
		    die("Connection failed: " . $this->conn->connect_error);
		} 
		return $this->connection;
	}

	protected function Close(){
		$this->connection->close();
	}

}
?>
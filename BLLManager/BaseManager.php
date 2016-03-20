<?php
require_once($_SESSION['documentRoot'] . '/DALManager/DataAccess.php');

class BaseManager{

	private $dataAccess;

	public function __construct($dataAccess){		
		$this->dataAccess = $dataAccess;				
	}

	protected function Create(){
		$this->dataAccess->Create();
	}

	protected function Update(){
		$this->dataAccess->Update();
	}

	protected function Delete(){
		$this->dataAccess->Delete();
	}

	protected function Read(){
		return $this->dataAccess->Read();
	}

}
?>
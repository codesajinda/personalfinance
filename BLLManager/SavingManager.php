<?php
require_once($_SESSION['documentRoot'] . '/BLLManager/BaseManager.php');
require_once($_SESSION['documentRoot'] . '/DALManager/SavingDataAccess.php');
require_once($_SESSION['documentRoot'] . '/Objects/Saving.php');
class SavingManager extends BaseManager{
	private $dataAccess;

	public function __construct(){
		$this->dataAccess = new SavingDataAccess();		
		parent::__construct($this->dataAccess);
	}		

	public function CreateSaving($saving){
		$success = false;

		if($saving != null)
		{			
			$params = array($saving->GetSavingName(), $saving->GetDescription(), $saving->GetDate(), $saving->GetAmount(), $saving->GetCategoryID(), $saving->GetUserID(), $saving->GetIsActive());		
			$success = $this->dataAccess->Create($params);		
		}

		return $success;
	}

}
?>
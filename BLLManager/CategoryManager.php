<?php
require_once($_SESSION['documentRoot'] . '/BLLManager/BaseManager.php');
require_once($_SESSION['documentRoot'] . '/DALManager/CategoryDataAccess.php');
require_once($_SESSION['documentRoot'] . '/Objects/Category.php');
class CategoryManager extends BaseManager{	

	private $dataAccess;

	public function __construct(){
		$this->dataAccess = new CategoryDataAccess();		
		parent::__construct($this->dataAccess);
	}

	public function CreateCategory($category){
		$success = false;

		if($category != null)
		{			
			$params = array($category->GetUserID(), $category->GetCategoryType(), $category->GetCategoryName(), $category->GetIsActive());		
			$success = $this->dataAccess->Create($params);		
		}

		return $success;
	}

	public function GetAllCategories($userID){
		$categories = null;
		$params = array($userID);		
		$rows = $this->dataAccess->GetAllCategories($params);
		if ($rows->num_rows > 0) {
			$categories = array();
		    while($row = $rows->fetch_assoc()) {
	        	$category = new Category();	
				$category->SetCategoryID($row['CategoryID']); 
				$category->SetCategoryName($row['CategoryName']);				
				$category->SetCategoryType($row['CategoryTypeID']);
				$categories[] = $category;
		    }
		 }
		
		return $categories;
	}
}

?>

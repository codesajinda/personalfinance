<?php
require_once($_SESSION['documentRoot'] .'/Objects/CategoryType.php');

class Category implements JsonSerializable {
	private $categoryID = -1;
	private $userID = -1;
	private $categoryName;	
	private $categoryType = CategoryType::None;
	private $isActive = false;

	public function GetCategoryID(){
		return $this->categoryID;
	}

	public function SetCategoryID($categoryID){
		$this->categoryID = $categoryID;
	}

	public function GetUserID(){
		return $this->userID;
	}

	public function SetUserID($userID){
		$this->userID = $userID;
	}

	public function GetCategoryName(){
		return $this->categoryName;
	}

	public function SetCategoryName($categoryName){
		$this->categoryName = $categoryName;
	}

	public function GetCategoryType(){
		return $this->categoryType;
	}

	public function SetCategoryType($categoryType){
		$this->categoryType = $categoryType;
	}

	public function GetIsActive(){
		return $this->isActive;
	}

	public function SetIsActive($isActive){
		$this->isActive = $isActive;
	}


	public function jsonSerialize() {
        return array('CategoryID' => $this->GetCategoryID(), 
        			'CategoryName' => $this->GetCategoryName(), 
        			'CategoryType' => $this->GetCategoryType(), 
        			'isActive' => $this->GetIsActive());
    }
}				
?>
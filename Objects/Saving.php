<?php
class Saving implements JsonSerializable{
	private $savingID;
	private $savingName;
	private $description;
	private $date;
	private $amount;
	private $categoryID;
	private $userID;
	private $isActive = false;

	public function GetSavingID(){
		return $this->savingID;
	}

	public function SetSavingID($savingID){
		$this->savingID = $savingID;
	}

	public function GetSavingName(){
		return $this->savingName;
	}

	public function SetSavingName($savingName){
		$this->savingName = $savingName;
	}

	public function GetDescription(){
		return $this->description;
	}

	public function SetDescription($description){
		$this->description = $description;
	}

	public function GetDate(){
		return $this->date;
	}

	public function SetDate($date){
		$this->date = $date;
	}

	public function GetAmount(){
		return $this->amount;
	}

	public function SetAmount($amount){
		$this->amount = $amount;
	}

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

	public function GetIsActive(){
		return $this->isActive;
	}

	public function SetIsActive($isActive){
		$this->isActive = $isActive;
	}

	public function jsonSerialize() {
        return array('SavingID' => $this->GetSavingID(), 
        			'SavingName' => $this->GetSavingName(), 
        			'Description' => $this->GetDescription(), 
        			'Date' => $this->GetDate(), 
        			'Amount' => $this->GetAmount(), 
        			'CategoryID' => $this->GetCategoryID(), 
        			'UserID' => $this->GetUserID(), 
        			'isActive' => $this->GetIsActive());
    }
}
?>
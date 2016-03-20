<?php

class HtmlHelper
{
	public static function LogoutButton() {
		$user = SessionHelper::GetSession('user');
		$buttonHtml = '';
		if($user!=null)
		{
	       $buttonHtml = '<md-button type="submit" id="btnLogout" name="btnLogout">Logout</md-button>';
		}    
		return $buttonHtml;
	}

	public static function BuildNavigation(){
		$user = SessionHelper::GetSession('user');
		$html = '';
		if($user != null){
			$html = '		
				 <md-menu>
				   <button ng-click="$mdOpenMenu()">Navigation</button>
				   <md-menu-content>
				   	 <md-menu-item type="radio" ng-model="Notification.mode" ng-value="0" ng-click="Notification.redirectToPage()">Home</md-menu-item>				   	 
          			 <md-menu-divider></md-menu-divider>
				     <md-menu-item type="radio" ng-model="Notification.mode" ng-value="1" ng-click="Notification.redirectToPage()">Expenses Report</md-menu-item>
				     <md-menu-item type="radio" ng-model="Notification.mode" ng-value="2" ng-click="Notification.redirectToPage()">Savings Report</md-menu-item>
              		 <md-menu-divider></md-menu-divider>
				     <md-menu-item type="radio" ng-model="Notification.mode" ng-value="3" ng-click="Notification.redirectToPage()">Add Expense or Saving</md-menu-item>
				     <md-menu-item type="radio" ng-model="Notification.mode" ng-value="4" ng-click="Notification.redirectToPage()">Categories</md-menu-item>
				   </md-menu-content>
				 </md-menu>';				 
		}
		return $html;
	}
}
?>
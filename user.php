<?php 
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
    require_once($_SESSION['documentRoot'] .'/controls/layout.php'); 
    require_once($_SESSION['documentRoot']. '/Utility/UserHelper.php');  
    require_once($_SESSION['documentRoot'] .'/Objects/User.php');  
    require_once($_SESSION['documentRoot']. '/BLLManager/UserManager.php');

    $loggedUser = UserHelper::Authenticate();
    $message = '';  
    $success = '';  
    $expenseSavings = ''; 
    $expenseReport = '';

    if ((isset($_POST["hdnUser"]) && !empty($_POST["hdnUser"]))){
        $postdata = json_decode($_POST['hdnUser'], true); 
        $user = new User();
        $userManager = new UserManager();
        $user->SetUsername($postdata['Username']);
        $user->SetPassword($postdata['Password']);
        $user->SetIsActive(1);
        $success = $userManager->CreateUser($user);
        if($success){
            $message = "Successfully added";
        }
        else{
            $message = "Failed to add";
        }
    }  

?>
<!--Constants-->
<script type="text/javascript">
    angular.module('personalFinance').constant('Constants', {
        message: {message:'<?php echo $message; ?>', success: '<?php echo $success; ?>'}
    });
</script> 
<div layout-md="column" layout-lg="column" ng-controller="UserController as User">
  <div flex>
    <form id="frmUser" name="frmUser" action="" method="post" ng-submit="Report.submitForm(frmUser, $event)" novalidate>
      <input type="hidden" id="hdnUser" name="hdnUser" value="{{User.user}}" /> 
      <div flex>
       <h5 class="md-title">User</h5>          
          <md-input-container>
            <label>Username:</label>
            <input ng-model="User.user.Username">
          </md-input-container>
          <md-input-container>
            <label>Password:</label>
            <input ng-model="User.user.Password"type="password">
          </md-input-container>
          <md-button type="submit" class="md-raised md-primary">Create</md-button> 
      </div>
    </form>
  </div>
</div>
<?php 
    require_once($_SESSION['documentRoot'] .'/controls/footer.php');
?>
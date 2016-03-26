<?php 
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
    require_once($_SESSION['documentRoot'] .'/controls/layout.php');
    require_once($_SESSION['documentRoot'] .'/BLLManager/UserManager.php');    
    require_once($_SESSION['documentRoot'] .'/Objects/User.php');

    $message = ''; 

    SessionHelper::ClearSession('user');

    if ((isset($_POST["username"]) && !empty($_POST["username"])) 
        && (isset($_POST["password"]) && !empty($_POST["password"]))){
        $userManager = new UserManager();
        $user = $userManager->Login(trim($_POST["username"]), trim($_POST["password"]));
        if($user != null){
            SessionHelper::SetSession('user', $user);
            header("Location: " .  $_SESSION['siteUrl'] . 'home.php');
            die();
        }
        else{
            $message = "Username and password is incorrect";
        }
    }
?>
<!--Constants-->
<script type="text/javascript">
    angular.module('personalFinance').constant('Constants', {
        message: {message:'<?php echo  $message?>', success: ''},
    });
</script> 
<form id="frmLogin" name="frmLogin" action="" method="post" ng-controller="LoginController as Login" flex layout-padding layout-align-lg="center center" layout-align-md="center center" layout-align-sm="center center" layout-align-xs="">    
    <h5 flex class="md-subhead">Login</h5>
      <md-input-container class="md-block">
        <label for="username">Username:</label>
        <input type="text" id="username"  name="username" placeholder="Username" />
      </md-input-container>
      <md-input-container class="md-block">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password" />
      </md-input-container>
      <div flex>
        <md-button type="submit" flex="30" class="md-raised md-primary">Login</md-button>
     </div>
</form>
<?php 
    require_once($_SESSION['documentRoot'] .'/controls/footer.php');
?>

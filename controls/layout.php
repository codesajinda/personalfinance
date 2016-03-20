<?php 
    //Trigger session to set the document root value
    require_once($_SERVER["DOCUMENT_ROOT"]. '/controls/global.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php 
    require_once($_SESSION['documentRoot'] .'/controls/header.php');
?>
<body ng-app="personalFinance" layout="column" layout-fill ng-controller="NotificationController as Notification">
<md-toolbar layout="row">
    <h1 flex layout-padding class="md-headline">Personal Finance</h1>
    <?php 
        require_once($_SESSION['documentRoot'] .'/controls/navigation.php');
    ?>
</md-toolbar>
<div layout="column" layout-margin>
	<notification message="Notification.message"></notification>


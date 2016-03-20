<?php 
session_start();
$_SESSION['siteUrl'] = 'http://' . $_SERVER["SERVER_NAME"] . '/'; 
$_SESSION['documentRoot'] = $_SERVER["DOCUMENT_ROOT"];
require_once($_SESSION['documentRoot']. '/Utility/SessionHelper.php');
require_once($_SESSION['documentRoot']. '/Utility/HtmlHelper.php');
?>
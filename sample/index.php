<?php
include_once(dirname(dirname(__FILE__))."/utils.php");
include_once(dirname(dirname(__FILE__))."/PUAPIBase.php");
include_once(dirname(__FILE__)."/VtigerWSContact.php");
$objContact=new VtigerWSContact();
$objContact->operation="getchallenge";
$objContact->username="admin";
$objResult=$objContact->getChallenge();
$objLogin=$objContact->getLoginObject();
$objLogin->operation="login";
$objLogin->username="admin";
$objLogin->accessKey=md5($objResult->result->token.'a8POcwcdfybGUX9G');
$objLoginInfo=$objLogin->login();
$objContact->setColumnData("lastname","lname1");
$objContact->setColumnData("firstname","fname1");
$objContact->setColumnData("email","email1");
$assigned_user_id=$objContact->getServerInfo("userId");
$objContact->setColumnData("assigned_user_id",$assigned_user_id);
$objContact->create("Contacts");
?>
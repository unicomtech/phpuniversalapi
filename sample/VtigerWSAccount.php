<?php
include_once(dirname(__FILE__)."/WSVtiger.php");
class VtigerWSContact
{
    public function __construct()
    {
    }
    
    public function render($data)
    {
        $objVtiger=new WSVtiger();
        $objVtiger->operation="getchallenge";
        $objVtiger->username="admin";
        $objResult=$objVtiger->getChallenge();
        $objLogin=$objVtiger->getLoginObject();
        $objLogin->operation="login";
        $objLogin->username="admin";
        $objLogin->accessKey=md5($objResult->result->token.'a8POcwcdfybGUX9G');
        $objLoginInfo=$objLogin->login();

        $objVtiger->setColumnData("lastname",$data["lastname"]);
        $objVtiger->setColumnData("firstname",$data["firstname"]);
        $objVtiger->setColumnData("email",$data["email"]);
        $assigned_user_id=$objVtiger->getServerInfo("userId");
        $objVtiger->setColumnData("assigned_user_id",$assigned_user_id);

        $objVtiger->create("Accounts"); 
    }
}
?>
<?php
include_once(dirname(__FILE__)."/WSVtiger.php");
class VtigerWSSales
{
    private $arrFieldMap=array("firstname"=>"firstname",
    "lastname"=>"lastname",
    "email"=>"email");
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
        
        $arrField=array();
        foreach($this->arrFieldMap as $field=>$remoteField)
        {
            if(isset($data[$field]))
            {
                $arrField[$remoteField]=$data[$field];
            }
        }      
        foreach($arrField as $field=>$value)
        {
            $objVtiger->setColumnData($field,$value);
        }
        
        $assigned_user_id=$objVtiger->getServerInfo("userId");
        $objVtiger->setColumnData("assigned_user_id",$assigned_user_id);

        return $objVtiger->create("Leads"); 
    }
}
?>
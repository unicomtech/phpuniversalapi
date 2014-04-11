<?php
class VtigerWSBase extends PUAPIAppBase
{
    protected $module="";
    public function __construct($module)
    {
        $this->module=$module;
        parent::__construct();
    }
    public function render($data)
    {
        $objVtiger=new WSVtiger();
        $accessKey=$objVtiger->getConfigValue("VTIGER_ACCESS_KEY");
        $objVtiger->operation="getchallenge";
        $objVtiger->username="admin";
        $objResult=$objVtiger->getChallenge();
        $objLogin=$objVtiger->getLoginObject();
        $objLogin->operation="login";
        $objLogin->username="admin";
        $objLogin->accessKey=md5($objResult->result->token.$accessKey);
        $objLoginInfo=$objLogin->login();
        if($objLoginInfo===false)
        {
            die("Login failed");
        }
        $arrField=$this->mapData($data);
        
        foreach($arrField as $field=>$value)
        {
            $objVtiger->setColumnData($field,$value);
        }
        
        $assigned_user_id=$objVtiger->getServerInfo("userId");
        $objVtiger->setColumnData("assigned_user_id",$assigned_user_id);

        return $objVtiger->create($this->module); 
    }
}
?>
<?php
include_once(dirname(__FILE__)."/WSVtiger.php");
class VtigerWSLead extends PUAPIAppBase
{
    
    public function __construct()
    {
        parent::__construct();
        $this->setMapField("firstname","firstname");
        $this->setMapField("lastname","lastname");
        $this->setMapField("email","email");
        $this->setMapField("phone","telephone");
        $this->setMapField("fax","fax");
        $this->setMapField("company","company");
        $this->setMapField("lane",false);
        $this->setMapField("code","postcode");
        $this->setMapField("city","city");
    }
    
    protected function on_field_map($vtigerField,$field,$arrData)
    {
        if($vtigerField=="lane")
        {
            return $data["address_1"]." ".$data["address_2"];
        }
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

        return $objVtiger->create("Leads"); 
    }
}
?>
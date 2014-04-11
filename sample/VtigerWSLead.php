<?php
include_once(dirname(__FILE__)."/WSVtiger.php");
include_once(dirname(__FILE__)."/VtigerWSBase.php");
class VtigerWSLead extends VtigerWSBase
{
    
    public function __construct()
    {
        parent::__construct("Leads");
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
    
    public function &render($data)
    {
        $ret=parent::render($data);
        return $ret;
    }
}
?>
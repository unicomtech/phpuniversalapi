<?php
include_once(dirname(__FILE__)."/WSVtiger.php");
include_once(dirname(__FILE__)."/VtigerWSBase.php");
class VtigerWSSales extends VtigerWSBase
{
    private $arrFieldMap=array();
    public function __construct()
    {
        parent::__construct("Leads");
        $this->setMapField("productname","model");
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
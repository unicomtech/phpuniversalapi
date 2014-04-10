<?php
class VtigerWSContact extends PUAPIBase
{
    protected $lastname="";
    protected $assigned_user_id="";
    protected $arrData=array();
    public function __construct()
    {
        parent::__construct();
    }
    public function setColumnData($columnField,$data)
    {
        $this->arrData[$columnField]=$data;
    }
    public function create($moduleName)
    {
        $session=$this->getServerInfo("sessionName");
        if(empty($this->arrData)) die("No data to insert. Add some data by calling setColumnData function");
        //fill in the details of the contacts.userId is obtained from loginResult.
        //$contactData  = array('lastname'=>'Valiant', 'assigned_user_id'=>$userId);
        //encode the object in JSON format to communicate with the server.
        $objectJson = json_encode($this->arrData);
        //name of the module for which the entry has to be created.

        //sessionId is obtained from loginResult.
        $params = array("sessionName"=>$session, "operation"=>'create', 
            "element"=>$objectJson, "elementType"=>$moduleName);
        $objResponse=PUAPIGetCURL("{$this->serverURL}/webservice.php", $params);

        //operation was successful get the token from the reponse.
        if($objResponse->success===false)
            die('create failed:'.print_r($objResponse,true));
        $savedObject = $objResponse->result;
        return $savedObject;
    }
}
?>

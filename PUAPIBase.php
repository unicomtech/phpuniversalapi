<?php
/** This file is part of PHPUniversalAPI.

*** PHPUniversalAPI is free software: you can redistribute it and/or modify
*** it under the terms of the GNU General Public License as published by
*** the Free Software Foundation, either version 3 of the License, or
*** (at your option) any later version.

*** PHPUniversalAPI is distributed in the hope that it will be useful,
*** but WITHOUT ANY WARRANTY; without even the implied warranty of
*** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*** GNU General Public License for more details.

*** You should have received a copy of the GNU General Public License
*** along with PHPUniversalAPI.  If not, see <http://www.gnu.org/licenses/>.*/

class PUAPIBase
{
    protected $module="";
    protected $objLogin=null;
    protected $session="";
    protected $serverURL="";
    public function __construct($module)
    {
        $this->module=$module;
        $this->serverURL="http://127.0.0.1:8080/projects/store/dnacrm";
        $this->objLogin=ClsAuieoWSLogin::getInstance($this->serverURL,'a8POcwcdfybGUX9G',"admin","admin");
    }
    public function create()
    {
        $this->session=  $this->objLogin->getSession();
        if(empty($this->arrData)) die("No data to insert. Add some data by calling setColumnData function");
        //fill in the details of the contacts.userId is obtained from loginResult.
        //$contactData  = array('lastname'=>'Valiant', 'assigned_user_id'=>$userId);
        //encode the object in JSON format to communicate with the server.
        $this->setColumnData("assigned_user_id",$this->objLogin->getLoginUserID());
        $objectJson = json_encode($this->arrData);
        //name of the module for which the entry has to be created.
        $moduleName = $this->module;

        //sessionId is obtained from loginResult.
        $params = array("sessionName"=>$this->session, "operation"=>'create', 
            "element"=>$objectJson, "elementType"=>$moduleName);
        $objResponse=auieoCURLGet("{$this->serverURL}/webservice.php", $params);

        //operation was successful get the token from the reponse.
        if($objResponse->success===false)
            die('create failed:'.$objResponse->error->errorMsg);
        $savedObject = $objResponse->result;
        return $savedObject;
    }
}
?>
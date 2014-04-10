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

include_once(dirname(__FILE__)."/PUAPILogin.php");

class PUAPIBase
{
    protected $module="";
    protected $objLogin=null;
    protected $session="";
    protected $serverURL="";
    protected $arrConfig=array();
    protected $arrGetData=array();
    protected $serverInfo=null;
    protected $arrStatus=array();
    
    public function __construct()
    {
        ob_start();
        include("config.php");
        ob_end_clean();
        $this->arrConfig = get_defined_vars();
        $this->serverURL=$this->arrConfig["PUAPI_SERVER_URL"];
    }
    public function __set($name, $value) 
    {
        if(in_array($name,$this->arrConfig["PUAPI_CHALLENGE_KEY"]))
        {
            $this->arrGetData[$name]=$value;
        }
        else
        {
            die("class variable {$name} not exist");
        }
    }
    public function getChallenge()
    {
        $strGetData=false;
        if(empty($this->arrGetData))
        {
            die("No get data set for getting challege. Expected data for operation, username");
        }
        foreach($this->arrGetData as $key=>$data)
        {
            if($strGetData===false)
            {
                $strGetData="{$key}={$data}";
            }
            else
            {
                $strGetData="{$strGetData}&{$key}={$data}";
            }
        }
        if($strGetData===false) $URL="{$this->serverURL}{$this->arrConfig["PUAPI_CHALLENGE_PAGE"]}";
        else $URL = "{$this->serverURL}{$this->arrConfig["PUAPI_CHALLENGE_PAGE"]}?{$strGetData}";
        
        $this->arrStatus["challenge"]=true;
        
        return json_decode(file_get_contents($URL));
    }
    public function &getLoginObject()
    {
        if(isset($this->arrConfig["PUAPI_CHALLENGE_PAGE"]) && !isset($this->arrStatus["challenge"])) die("Challenge method has to be called before getting login object");
        $this->objLogin = PUAPILogin::getInstance($this->serverURL);
        return $this->objLogin;
    }
    public function getServerInfo($key)
    {
        return $this->objLogin->getResult($key);
    }
}
?>
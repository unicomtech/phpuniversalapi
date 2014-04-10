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

class PUAPILogin
{
    private $serverInfo=array();
    private $arrPostData=array();
    private $arrGetData=array();
    private $arrConfig=array();
    
    public function __construct()
    {
        ob_start();
        include("config.php");
        ob_end_clean();
        $this->arrConfig = get_defined_vars();
    }
    public static function &getInstance()
    {
        static $instance=null;
        if(is_null($instance))
        {
            $instance=new PUAPILogin();
        }
        return $instance;
    }
    public function __set($name, $value) 
    {
        if(in_array($name,$this->arrConfig["PUAPI_LOGIN_POST_KEY"]))
        {
            $this->arrPostData[$name]=$value;
        }
        else if(in_array($name,$this->arrConfig["PUAPI_LOGIN_GET_KEY"]))
        {
            $this->arrGetData[$name]=$value;
        }
        else
        {
            die("class variable {$name} not exist");
        }
    }
    public function login()
    {
        if(empty($this->arrPostData) && empty($this->arrGetData))
        {
            die("No post data or get data set for login");
        }

        $loginURL = "{$this->arrConfig["PUAPI_SERVER_URL"]}{$this->arrConfig["PUAPI_LOGIN_PAGE"]}";

        $strGetData=false;
        if($this->arrGetData)
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
        
        if($strGetData===false) $URL=$loginURL;
        else $URL = "{$loginURL}?{$strGetData}";

        if(empty($this->arrPostData))
        {
            $this->serverInfo=file_get_contents($URL); 
        }
        else
        {
            $this->serverInfo=PUAPIGetCURL($URL,$this->arrPostData);
        }
        return $this->serverInfo;
    }
    public function getResult($key)
    {
        return isset($this->serverInfo->result->$key)?$this->serverInfo->result->$key:null;
    }
}
?>
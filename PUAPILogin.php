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
    private $serverAddress="";
    private $accessKey="";
    private $serverInfo=array();
    public function __construct($serverAddress,$accessKey)
    {
        $this->serverAddress=$serverAddress;
        $this->accessKey=$accessKey;
    }
    public static function &getInstance($serverAddress,$accessKey,$username,$password)
    {
        static $instance=null;
        if(is_null($instance))
        {
            $instance=new PUAPILogin($serverAddress,$accessKey);
            $instance->login($username,$password);
        }
        return $instance;
    }
    private function login($username,$password)
    {
        static $response=null;
        if(!is_null($response)) return $response;
        ####################### SERVER #####################
        $ServerAddress = $this->serverAddress;
        $CRM_UserName = $username;
        $CRM_UserPassword = $password;
        $CRM_UserAccessKey = $this->accessKey;;
        
        #######[1]############### TAKE TOKEN ###################################
        $TOKEN_URL = $ServerAddress."/webservice.php?operation=getchallenge&&username=".$CRM_UserName;
        $TOKEN_DATA = json_decode(file_get_contents($TOKEN_URL));

        $CRM_TOKEN = $TOKEN_DATA->result->token;

        #######[2]############### LOGIN TO CRM ###################################
        $service_url = $ServerAddress."/webservice.php";
        $curl_post_data = array(
    'operation' => 'login',
    'username' => $CRM_UserName,
    'accessKey' => md5($CRM_TOKEN.$CRM_UserAccessKey),
    );
        $this->serverInfo=auieoCURLGet($service_url,$curl_post_data);
    }
    public function getSession()
    {
        return $this->serverInfo->result->sessionName;
    }
    public function getServerURL()
    {
        return $this->serverAddress;
    }
    public function getLoginUserID()
    {
        return $this->serverInfo->result->userId;
    }
}
?>
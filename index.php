<?php
function auieoCURLGet($url,$curl_post_data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
    $json = json_decode(curl_exec($curl));
    return $json;
}
class ClsAuieoWSLogin
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
            $instance=new ClsAuieoWSLogin($serverAddress,$accessKey);
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

class ClsAuieoHTTP
{
    public function __construct()
    {
        
    }
    public function post($url,$param)
    {
        
    }
}

class ClsAuieoWSContact extends ClsAuieoWSBase
{
    protected $lastname="";
    protected $assigned_user_id="";
    protected $arrData=array();
    public function __construct()
    {
        parent::__construct("Contacts");
    }
    public function setColumnData($columnField,$data)
    {
        $this->arrData[$columnField]=$data;
    }
}

class ClsAuieoWSBase
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
class ClsAuieoWSLeads extends ClsAuieoWSBase
{
    public function __construct() {
        parent::__construct();
    }
    
}
?>
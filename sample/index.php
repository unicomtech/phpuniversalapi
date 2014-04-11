<?php

include_once(dirname(dirname(__FILE__))."/PUAPI.php");
include_once(dirname(__FILE__)."/VtigerWSProduct.php");
include_once(dirname(__FILE__)."/VtigerWSLead.php");

///this has to be used as hook at remote application. The input data is from the remort application
/**
 * 
 * @param type $arrData - associative array with key as field name and value as field data
 */
function on_customer_insert($arrData)
{
    $obj=new VtigerWSLead();
    $ret=$obj->render($arrData);
}

$arrData=array();
$arrData["lastname"]="lname13";
$arrData["firstname"]="fname13";
$arrData["email"]="email13";

on_customer_insert($arrData);

?>
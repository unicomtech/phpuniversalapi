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

include_once(dirname(dirname(__FILE__))."/utils.php");
include_once(dirname(dirname(__FILE__))."/PUAPILogin.php");
include_once(dirname(dirname(__FILE__))."/PUAPIBase.php");
include_once(dirname(__FILE__)."/PUAPIContact.php");
$objContact=new PUAPIContact();
$objContact->setColumnData("lastname",$data["lastname"]);
$objContact->setColumnData("firstname",$data["firstname"]);
$objContact->setColumnData("email",$data["email"]);
$objContact->create();
?>
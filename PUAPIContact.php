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

class PUAPIContact extends PUAPIBase
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
?>

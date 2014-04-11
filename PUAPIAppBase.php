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

class PUAPIAppBase
{
    private $arrFieldMap=array();
    public function __construct()
    {
        
    }
    protected function setMapField($remoteField,$field)
    {
        $this->arrFieldMap[$remoteField]=$field;
    }
    public function &mapData($data)
    {
        $arrField=array();
        if(!isset($this->arrFieldMap)) die("Class variable arrFieldMap not found");
        foreach($this->arrFieldMap as $remoteField=>$field)
        {
            if(isset($data[$field]))
            {
                $remoteFieldData=$data[$field];
                if(method_exists($this, "on_field_map"))
                {
                    $tmp=$this->on_field_map($remoteField,$field,$data);
                    if(!is_null($tmp))
                    {
                        $$remoteFieldData=$tmp;
                    }
                }
                $arrField[$remoteField]=$remoteFieldData;
            }
        }
        return $arrField;
    }
}
?>
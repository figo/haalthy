<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

class ProfileModule extends Gdn_Module {
   
   protected $_TagData;
   protected $_UserID;
   
   public function __construct($Sender = '') {
      parent::__construct($Sender);
   }
   
   public function GetData($UserID = '') {
      if (is_numeric($UserID) && $UserID > 0) {
         $this->_UserID = $UserID;
         $profiles = Gdn::SQL()
             ->Select('UserPatient.PatientID')
             ->From('UserPatient')
             ->Where('UserPatient.UserID = ', $UserID)
             ->Get()->ResultArray();

      }    
   }

   public function AssetTarget() {
      return 'Panel';
   }

   public function ToString() {
      $String = "profile";
      return $String;
   }
}

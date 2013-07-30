<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

// Define the plugin:
$PluginInfo['profile'] = array(
   'Name' => 'profile',
   'Description' => 'Allow input profile.',
   'Version' => '0.1',
   'SettingsUrl' => '/dashboard/settings/tagging',
   'SettingsPermission' => 'Garden.Settings.Manage',
   'Author' => "Lily",
   'AuthorEmail' => 'lilyangel007@gmail.com',
   'AuthorUrl' => ''
);

class ProfilePlugin extends Gdn_Plugin {
   public function CategoriesController_Render_Before($Sender) {
      $this->_AddProfileModule($Sender);
   }

   /**
    * Display the tag module in a discussion.
    */
   public function DiscussionController_Render_Before($Sender) {
      $this->_AddProfileModule($Sender);
   }

   /**
    * Display the tag module on discussions lists.
    * @param DiscussionsController $Sender
    */
   public function DiscussionsController_Render_Before($Sender) {
      $this->_AddProfileModule($Sender);
   }
   private function _AddProfileModule($Sender) {
      
      include_once(PATH_PLUGINS.'/PatientProfile/class.profilemodule.php');
      $ProfileModule = new ProfileModule($Sender);
      $ProfileModule->GetData($DiscussionID);
      $Sender->AddModule($ProfileModule);      
   }   
 
}

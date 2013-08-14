<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

class TagModule extends Gdn_Module {
   
   protected $_TagData;
   protected $_DiscussionID;
   protected $_UserTag;
   protected $_User;

   public function __construct($Sender = '') {
      $this->_TagData = FALSE;
      $this->_UserTag = FALSE;
      $this->_DiscussionID = 0;
      $this->_User = Gdn::Session()->UserID;
      parent::__construct($Sender);
   }
   
   public function GetData($DiscussionID = '') {
      $SQL = Gdn::SQL();
/*      if (is_numeric($DiscussionID) && $DiscussionID > 0) {
         $this->_DiscussionID = $DiscussionID;
         $SQL->Join('TagDiscussion td', 't.TagID = td.TagID')
            ->Where('td.DiscussionID', $DiscussionID);
      } else {
 */         $SQL->Where('t.CountDiscussions >', 0, FALSE);
 //     }
            
      $this->_TagData = $SQL
         ->Select('t.*')
         ->From('Tag t')
         ->OrderBy('t.CountDiscussions', 'desc')
         ->Limit(25)
         ->Get();
      $this->_UserTag = Gdn::Database()->SQL()
          ->Select('ut.TagID')
          ->Select('ut.UserID')
          ->Select('t.Name')
          ->From('UserTag ut')
          ->Join('Tag t', 'ut.TagID = t.TagID')
          ->OrderBy('ut.TagID')
          ->Where('ut.UserID =',Gdn::Session()->UserID)
          ->Get();
       }

   public function AssetTarget() {
      return 'Panel';
   }

   public function ToString() {
      if ($this->_TagData->NumRows() == 0)
         return '';
      
      $String = '';
      ob_start();
      ?>
      <div class="Box Tags">
         <h4><?php echo T('Favorite Tags'); ?></h4>
         <ul class="PanelInfo" id="FavoriteTags"><?php
            foreach($this->_UserTag as $UserTag){
                ?>
                <li id = "Tag<?php echo $UserTag->TagID?>"><strong><?php 
                if (urlencode($UserTag->Name) == $UserTag->Name) {
                    echo Anchor(htmlspecialchars($UserTag->Name), 'discussions/tagged/'.urlencode($UserTag->Name));
                } else {
                    echo Anchor(htmlspecialchars($UserTag->Name), 'discussions/tagged?Tag='.urlencode($UserTag->Name));
                }
                echo '</strong>
                <div class="favoriteTag"> 
                    <a href="javascript:changeToUnFavorite('.$UserTag->TagID.', '.$this->_User.', \''.Gdn::Request()->Url('plugin/updateusertag').'\');"><img id="favriteTag'.$UserTag->TagID.'" src="favoritestar.png" border="0" height="15" width="15"></a>
            </div></li>';

            }
           ?>
         </ul>
         <h4><?php echo T('Popular Tags'); ?></h4>
         <ul class="PanelInfo" id="SuggestedTags">
        <?php
        $TagIDs = array();
        foreach($this->_UserTag as $TagID){
            array_push($TagIDs, $TagID->TagID); 
        }         
         foreach ($this->_TagData->Result() as $Tag) {
            if (($Tag->Name != '')&&!in_array($Tag->TagID, $TagIDs)) {
         ?>
             <li id = "Tag<?php echo $Tag->TagID?>"><strong><?php 
                    if (urlencode($Tag->Name) == $Tag->Name) {
                        echo Anchor(htmlspecialchars($Tag->Name), 'discussions/tagged/'.urlencode($Tag->Name));
                    } else {
                        echo Anchor(htmlspecialchars($Tag->Name), 'discussions/tagged?Tag='.urlencode($Tag->Name));
                    }
                ?></strong>
                <div class='favoriteTag'> 
                <?php
                    $taglink;
                    if (urlencode($Tag->Name) == $Tag->Name) {
                        $taglink=Anchor(htmlspecialchars($Tag->Name), 'discussions/tagged/'.urlencode($Tag->Name));
                    } else {
                        $taglink=Anchor(htmlspecialchars($Tag->Name), 'discussions/tagged?Tag='.urlencode($Tag->Name));
                    }
                    echo '<a href="javascript:changeToFavorite('.$Tag->TagID.', '.$this->_User.', \''.Gdn::Request()->Url('plugin/updateusertag').'\');"><img id="favriteTag'.$Tag->TagID.'" src="unfavoritestar.png" border="0" height="15" width="15"></a>';
                ?>
            </div></li>
         <?php
            }
         }
         ?>
         </ul>
      </div>
      <?php
      $String = ob_get_contents();
      @ob_end_clean();
      return $String;
   }
}

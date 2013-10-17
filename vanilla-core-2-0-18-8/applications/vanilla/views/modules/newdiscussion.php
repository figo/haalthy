<?php if (!defined('APPLICATION')) exit();
echo Anchor(T(gettext('Start a New Discussion')), '/post/discussion'.(array_key_exists('CategoryID', $Data) ? '/'.$Data['CategoryID'] : ''), 'BigButton NewDiscussion');

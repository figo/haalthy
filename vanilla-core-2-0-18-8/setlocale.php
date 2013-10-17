<?php
// I18N support information here
 $language = 'zh_CN';
 putenv("LANG=$language"); 
 setlocale(LC_ALL, $language);

 // Set the text domain as 'messages'
 $domain = 'messages';
 bindtextdomain($domain, "./locale"); 
 textdomain($domain);
 ?>

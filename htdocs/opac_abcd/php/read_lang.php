<?php
if (isset($msg_path) and $msg_path!="")
iF (!isset($msgstr["menu_1"])) $msgstr["menu_1"]="LogOut";
iF (!isset($msgstr["menu_2"])) $msgstr["menu_2"]="General";
if (file_exists($a)) {

$a=$path."/lang/".$_REQUEST["lang"]."/opac.tab";
if (file_exists($a)) {
			if ($charset=="UTF-8")
            	$m[1]=utf8_encode($m[1]);
?>
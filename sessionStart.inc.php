<?php
$sessionName = "SID".md5('/');
if ($_SERVER['HTTP_HOST'] <> 'localhost')   @ini_set("session.save_path",$host2 . 'sessions');
else @ini_set("session.save_path",$host2 . 'sessions');
//else   @ini_set("session.save_path",'c:\php-sdk');
$sessionDomain = "/";

session_name($sessionName);
@ini_set("session.cookie_path",$sessionDomain);
session_start();
?>
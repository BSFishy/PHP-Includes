<?php
// host
$host = ($_SERVER['HTTP_HOST'] == 'localhost' ? 'localhost' : 'sql301.my.vg');
$hostssl = ($_SERVER['HTTP_HOST'] == 'localhost' ? '/localhost' : 'endercraftnetwork.my.vg');
$host2 = ($_SERVER['HTTP_HOST'] == 'localhost' ? '/home/matt/www/Endercraft/' : '/home/vol7_8/my.vg/myvg_16421860/endercraftnetwork.my.vg/');
$wsite = 'localhost';
$wsitename = 'Websitemane';

// database
$dbuser = ($_SERVER['HTTP_HOST'] == 'localhost' ? 'endercraft' : 'myvg_16421860');
$dbname = ($_SERVER['HTTP_HOST'] == 'localhost' ? 'endercraft' : 'myvg_16421860_endercraft');
$dbpass = ($_SERVER['HTTP_HOST'] == 'localhost' ? '20end16' : '20matt02');
//echo "$host $dbname $dbuser $dbpass";

// brute force login protection
$ini['bftime'] = 600; 	// seconds to wait until allowed to login again
$ini['bfattempts'] = 5;	// # of login attempts before blocked

// email
//$admin = 'admin@thefabook.com';
//$returnpath = 'noreply@thefabook.com';
//$from = 'FB Website <noreply@thefabook.com>';
//$bcc = 'mttprvstanddad@gmail.com';
//$mailserver = 'mail.heartofseagrove.com';
//$port = 26;
//$username = 'noreply+thefabook.com';
//$emailpass = '20hos12';
$hostsite = 'WS';
?>

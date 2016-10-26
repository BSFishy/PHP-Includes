<?php
// host
$host = ($_SERVER['HTTP_HOST'] == 'localhost' ? '' : '');
$hostssl = ($_SERVER['HTTP_HOST'] == 'localhost' ? '' : '');
$host2 = ($_SERVER['HTTP_HOST'] == 'localhost' ? '' : '');
$wsite = 'localhost';
$wsitename = 'Websitemane';

// database
$dbuser = ($_SERVER['HTTP_HOST'] == 'localhost' ? '' : '');
$dbname = ($_SERVER['HTTP_HOST'] == 'localhost' ? '' : '');
$dbpass = ($_SERVER['HTTP_HOST'] == 'localhost' ? '' : '');
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

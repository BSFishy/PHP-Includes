<?php
// host
$host = ($_SERVER['HTTP_HOST'] == 'localhost' ? 'localhost' : 'database host');
$hostssl = ($_SERVER['HTTP_HOST'] == 'localhost' ? '/localhost' : 'classrmcash.com.nu');
$host2 = ($_SERVER['HTTP_HOST'] == 'localhost' ? 'local directory' : 'directory on online server');
$wsite = 'localhost';
$wsitename = 'Websitemane';

// database
$dbuser = 'username';
$dbname = 'database name';
$dbpass = 'user password';

// brute force login protection
$ini['bftime'] = 600; 	// seconds to wait until allowed to login again
$ini['bfattempts'] = 5;	// # of login attempts before blocked

// email
$admin = 'admin@thefabook.com';
$returnpath = 'noreply@thefabook.com';
$from = 'FB Website <noreply@thefabook.com>';
$bcc = 'mttprvstanddad@gmail.com';
$mailserver = 'mail.heartofseagrove.com';
$port = 26;
$username = 'noreply+thefabook.com';
$emailpass = '20hos12';
$hostsite = 'WS';
?>

<?php
date_default_timezone_set('America/Chicago');
include_once("ini.inc.php");
include_once("sessionStart.inc.php");
include_once("db.inc.php");
$db = new db($host, $dbname, $dbpass, $dbuser);
include_once("login.inc.php");
$login = new loginutils($db);
$yr = date("Y");

function filter_by_value ($array, $index, $value){
    $newarray = array();
    if(is_array($array) && count($array)>0)
    {
        foreach(array_keys($array) as $key){
            $temp[$key] = $array[$key][$index];

            if ($temp[$key] == $value){
                $newarray[$key] = $array[$key];
            }
        }
    }
    return $newarray;
}
function randomPass($count = 8) {
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L",
                    "m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T", "u","U","v","V","w","W","x","X","y","Y","z",
                    "Z","1","2","3","4","5","6","7","8","9","0");

		$max_chars = count($chars) - 1;
		srand((double)microtime()*1000000);

		for($i = 0; $i < $count; $i++)	{
			$newPass = ($i == 0) ? $chars[rand(0, $max_chars)] : $newPass . $chars[rand(0, $max_chars)];
		}

		return $newPass;
}
function formatPhone($phone = '', $convert = false, $trim = true){
    // If we have not entered a phone number just return empty
    if (empty($phone)) {
        return '';
    }
    // Strip out any extra characters that we do not need only keep letters and numbers
    $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);
    // Do we want to convert phone numbers with letters to their number equivalent?
    // Samples are: 1-800-TERMINIX, 1-800-FLOWERS, 1-800-Petmeds
    if ($convert == true) {
        $replace = array('2'=>array('a','b','c'),
        '3'=>array('d','e','f'),
        '4'=>array('g','h','i'),
        '5'=>array('j','k','l'),
        '6'=>array('m','n','o'),
        '7'=>array('p','q','r','s'),
        '8'=>array('t','u','v'), '9'=>array('w','x','y','z'));
        // Replace each letter with a number
        // Notice this is case insensitive with the str_ireplace instead of str_replace
        foreach($replace as $digit=>$letters) {
            $phone = str_ireplace($letters, $digit, $phone);
        }
    }
    // If we have a number longer than 11 digits cut the string down to only 11
    // This is also only ran if we want to limit only to 11 characters
    if ($trim == true && strlen($phone)>11) {
        $phone = substr($phone, 0, 11);
    }
    // Perform phone number formatting here
    if (strlen($phone) == 7) {
        return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1-$2", $phone);
    } elseif (strlen($phone) == 10) {
        return preg_replace("/([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "($1) $2-$3", $phone);
    } elseif (strlen($phone) == 11) {
        return preg_replace("/([0-9a-zA-Z]{1})([0-9a-zA-Z]{3})([0-9a-zA-Z]{3})([0-9a-zA-Z]{4})/", "$1($2) $3-$4", $phone);
    }
    // Return original phone if not 7, 10 or 11 digits long
    return $phone;
}
function rescal($yr, $res, $r = 0) {
    $cal = new Calendar;
    echo '<center><table class="calmain">';
    for ($i=0;$i<3;$i++){
        echo '<tr>';
        for ($j=0;$j<4;$j++){
            $index = ($i*4)+$j;
            $m = (date('n')+$index <=12 ? date('n') + $index : date('n')+$index-12);
            $y = (date('n')+$index <=12 ? $yr : $yr + 1);
            echo '<td class = "cal">'.$cal->getSchMonth($m, $y, $res, $r).'</td>';
        }
        echo '</tr>';
    }
    echo '</table></center>';
}
?>

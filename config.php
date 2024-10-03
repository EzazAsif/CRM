<?php
ob_start(); //Turns on output buffering
ini_set('date.timezone','Asia/Manila');//Sets timezone, ensuring date and time zone return accurate values
date_default_timezone_set('Asia/Manila');//alternate way to Set timezone, ensuring date and time zone return accurate values
session_start();//session start to maintain the users state

require_once('initialize.php');
require_once('classes/DBConnection.php');//Database Connection
require_once('classes/SystemSettings.php');//System Wide Configuration Settings
$db = new DBConnection;
$conn = $db->conn;//Assigns database connection to a variable

//function to redirect to a specific page
function redirect($url=''){
	if(!empty($url))
	echo '<script>location.href="'.base_url .$url.'"</script>';
}

//function to validate image if not returning no image
function validate_image($file){
	if(!empty($file)){
			// exit;
		if(is_file(base_app.$file)){
			return base_url.$file;
		}else{
			return base_url.'dist/img/no-image-available.png';
		}
	}else{
		return base_url.'dist/img/no-image-available.png';
	}
}

//function to check if mobile by using common device keywords
function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}
ob_end_flush();//flushes the output buffer, sending its contents to the browser
?>
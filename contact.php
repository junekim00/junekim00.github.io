<?php

$webmaster_email = "junek@usc.edu";

$feedback_page = "contact.html";
$error_page = "error.html";
$confirm_page = "confirm.html";

$Email = $_REQUEST['Email'] ;
$Message = $_REQUEST['Message'] ;
$Name = $_REQUEST['Name'] ;
$msg =
"Name: " . $Name . "\r\n" . 
"Email: " . $Email . "\r\n" . 
"Message: " . $Message ;

function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

if (!isset($_REQUEST['Email'])) {
header( "Location: $feedback_page" );
}

elseif (empty($Name) || empty($Email) || empty($Message)){
header( "Location: $error_page" );
}

elseif ( isInjected($Email) || isInjected($Name)  || isInjected($Message) ) {
header( "Location: $error_page" );
}

else {

	mail( "$webmaster_email", "Contact Form Results", $msg );

	header( "Location: $confirm_page" );
}
?>
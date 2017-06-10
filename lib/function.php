<?php

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if (!empty($message)) { 
    return $message;
  } else {
    return "";
  }
}

function log_action($action, $message="") {
	$datestamp = strftime("%Y-%m-%d", time());
	$logfile = '../logs/log for '.$datestamp.'.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
	//TO DO: get more user info, make the log more organized and readable
	$content = "IP of User: {$_SERVER[REMOTE_ADDR]} {$timestamp} |  {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function en_al($input=""){
	$result = md5($input);
	return substr(sha1(substr($result,10)),20);
	}




?>
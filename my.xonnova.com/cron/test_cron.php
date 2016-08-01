<?php
// The message
	$message = "Line 1\r\nLine 2\r\nLine 3";
	
	// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70, "\r\n");
	
	// Send
	mail('kvkaushal@gmail.com', 'FROM CRON FILE '.date("Y-m-d H:i:s"), $message);
//exec("wget -O - -q -t 1 'http://masterdealercode.com/soft/admin/cron/test_cron'");
?>
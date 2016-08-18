<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

$data = json_decode(file_get_contents("php://input"));
$name = $data->name;
$visitor_email = $data->visitorEmail;
$message = $data->message;

$email_from = "firdaus_maarof@yahoo.com";//<== update the email address
$email_subject = "New Feedback";
$email_body = "You have received a new feedback from the user $name.\n".
    "Here is the message:\n $message".
    
$to = "firdaus_maarof@yahoo.com";//<== update the email address
$headers = "From: $email_from\r\n";
$headers .= "Reply-To: $visitor_email\r\n";
//Send the email!
if(mail($to,$email_subject,$email_body,$headers)){
	echo("success");
}else {
	echo("fail");
}
?> 
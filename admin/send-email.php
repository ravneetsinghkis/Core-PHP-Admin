<?php
$to = $_POST['email_id'];
$subject = 'Invite Email';
$headers =  'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'From: '.$to.' <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
$message = 'Hi '.$to;
$message .= 'This is a Invite email sent from Admin. Please click on this <a href="http://localhost/core-php/signup.php?inviteuser='.base64_encode($to).'">link</a> and complete your registration process.';
// send email
$mail_sent=mail($to,$subject,$message,$headers);
$response = array();
    if($mail_sent){
        $response = array(
            'status' => true,
            'message' => 'Mail sent succesfully',
        );
    }else{
         $response = array(
            'status' => false,
            'message' => 'Something Went Wrong. Please try again later',
        );
    }
echo json_encode($response);
?>
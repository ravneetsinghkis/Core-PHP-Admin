<?php
include('includes/config.php');
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
  
require 'vendor/autoload.php';

$mail = new PHPMailer;
if(isset($_POST['send'])){
    $femail=$_POST['femail'];
    $row1=mysqli_query($con,"select * from users where email='$femail'");
    $row2=mysqli_fetch_array($row1);
   
if($row2>0)
{
    $emailid = $row2['id'];
    $toemail = $row2['email'];
    $fname = $row2['fname'];
    $subject = "Reset Password";
    $message = 'Please click on this <a href="http://localhost/core-php/update-password.php?reset_id='.md5($row2['id']).'"> link </a> to reset the password';
    $mail->isSMTP();                            // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                     // Enable SMTP authentication
    $mail->Username = 'zswsws@gmail.com';    // SMTP username
    $mail->Password = 's'; // SMTP password
    $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                          // TCP port to connect to
    $mail->setFrom('xsx.kis@gmail.com','Ravneet');
    $mail->addAddress($toemail);   // Add a recipient
    $mail->isHTML(true);  // Set email format to HTML
    $bodyContent=$message;
    $mail->Subject =$subject;
    $bodyContent = 'Dear'." ".$fname;
    $bodyContent .='<p>'.$message.'</p>';
    $mail->Body = $bodyContent;
if(!$mail->send()) {
    echo  "<script>alert('Message could not be sent');</script>";
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
   echo  "<script>alert('We have sent Email. Please check and reset your password');</script>";
}

}
else
{
echo "<script>alert('Email not register with us');</script>";   
}
}






?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Password Reset | Registration and Login System</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                                        <div class="card-body">

                                        <div class="small mb-3 text-muted">Enter your email address and we will send you password on your email</div>


                                        <form method="post">
                                                                                
                                        <div class="form-floating mb-3">
                                        <input class="form-control" name="femail" type="email" placeholder="name@example.com" required />
                                        <label for="inputEmail">Email address</label>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="login.php">Return to login</a>
                                        <button class="btn btn-primary" type="submit" name="send">Send Reset Password </button>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="signup.php">Need an account? Sign up!</a></div>
                        <div class="small"><a href="login.php">Back to Home</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
       <?php include('includes/footer.php');?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

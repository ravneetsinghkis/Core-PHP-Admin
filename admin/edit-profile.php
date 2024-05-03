<?php session_start();
include_once('../includes/config.php');
include_once('../send-customer-email.php');
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
  } else{
//Code for Updation 
if(isset($_POST['update']))
{
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $contact=$_POST['contact'];
    $userid=$_GET['uid'];
    $is_approve=$_POST['is_approve'];
    $ret= mysqli_query($con,"SELECT id,fname,email,is_approve FROM users WHERE id='$userid'");
    $num=mysqli_fetch_array($ret);
    if($num>0)
    {
        $oldapproval=$num['is_approve'];
        if($is_approve!=$oldapproval){
            $email_id=$num['email'];
            $msg=mysqli_query($con,"update users set is_approve='$is_approve' where id='$userid'");
            if($msg)
                {
                    if($is_approve==0){
                        $subject="Account Unapproved";
                        $message="Hi ".$email_id."<br>";
                        $message.="Your Account has been Unapproved by Admin.Due to some reason. Please contact with administrator";
                    }else{
                        $subject="Account Approved";
                        $message="Hi ".$email_id."<br>";
                        $message.="Congratulations, Your Account has been Approved by Admin";
                    }
                    send_data_via_mail($email_id,$subject,$message);
                    echo "<script>alert('Profile updated successfully');</script>";
                    echo "<script type='text/javascript'> document.location = 'manage-users.php'; </script>";
                }
        }
       // die;
    }
    $msg=mysqli_query($con,"update users set fname='$fname',lname='$lname',contactno='$contact' where id='$userid'");
    if($msg)
    {
        echo "<script>alert('Profile updated successfully');</script>";
        echo "<script type='text/javascript'> document.location = 'manage-users.php'; </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edit Profile | Registration and Login System</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
      <?php include_once('includes/navbar.php');?>
        <div id="layoutSidenav">
          <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">  
                        <?php 
                        $userid=$_GET['uid'];
                        $query=mysqli_query($con,"select * from users where id='$userid'");
                        while($result=mysqli_fetch_array($query))
                        {?>
                        <h1 class="mt-4"><?php echo $result['fname'];?>'s Profile</h1>
                        <div class="card mb-4">
                     <form method="post">
                            <div class="card-body">
                                <table class="table table-bordered">
                                   <tr>
                                    <th>First Name</th>
                                       <td><input class="form-control" id="fname" name="fname" type="text" value="<?php echo $result['fname'];?>" required /></td>
                                   </tr>
                                   <tr>
                                       <th>Last Name</th>
                                       <td><input class="form-control" id="lname" name="lname" type="text" value="<?php echo $result['lname'];?>"  required /></td>
                                   </tr>
                                    <tr>
                                       <th>Approve User.</th>
                                       <td colspan="3">
                                        <select class="form-control" id="is_approve" name="is_approve" required>
                                            <option value="1" <?php if($result["is_approve"]==1){echo 'selected';}else { echo ''; } ?>>Yes</option>   
                                            <option value="0" <?php if($result["is_approve"]==0){echo 'selected';}else { echo ''; } ?>>No</option>   
                                        </select>
                                    </td>
                                   </tr>
                                   <tr>
                                       <th>Email</th>
                                       <td colspan="3"><?php echo $result['email'];?></td>
                                   </tr>
                               
                                    <tr>
                                       <th>Reg. Date</th>
                                       <td colspan="3"><?php echo $result['posting_date'];?></td>
                                   </tr>
                                   <tr>
                                       <td colspan="4" style="text-align:center ;"><button type="submit" class="btn btn-primary btn-block" name="update">Update</button></td>

                                   </tr>
                                    </tbody>
                                </table>
                            </div>
                            </form>
                        </div>
<?php } ?>

                    </div>
                </main>
          <?php include('../includes/footer.php');?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>

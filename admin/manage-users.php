<?php session_start();
include_once('../includes/config.php');
include_once('../send-customer-email.php');
if (strlen($_SESSION['adminid']==0)) {
  header('location:logout.php');
} else{
// for deleting user
if(isset($_GET['id']))
{
    $adminid=$_GET['id'];
    $msg=mysqli_query($con,"delete from users where id='$adminid'");
    if($msg)
    {
    echo "<script>alert('Data deleted');</script>";
    }
}
if(isset($_POST['approved_id']))
{
    $is_approved=$_POST['is_approved'];
    $user_id=$_POST['user_id'];
    $row= mysqli_query($con,"SELECT id,fname,email,is_approve FROM users WHERE id='$user_id'");
    $num=mysqli_fetch_array($row);
    if($num>0){
        $email_id=$num['email'];
        $msg=mysqli_query($con,"update users set is_approve='$is_approved' where id='$user_id'");
        if($is_approved==0){
            $subject="Account Unapproved";
            $message="Hi ".$email_id."<br>";
            $message.="Your Account has been Unapproved by Admin.Due to some reason. Please contact with administrator";
        }else{
            $subject="Account Approved";
            $message="Congratulations ".$email_id."<br>";
            $message.="Your Account has been Approved by Admin";
        }
        send_data_via_mail($email_id,$subject,$message);
        echo "<script>alert('User Record Updated Successfully');</script>";
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
        <title>Manage Users | Registration and Login System</title>
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
                        <h1 class="mt-4">Manage users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage users</li>
                        </ol>
            
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Registered User Details
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email Id</th>
                                            <th>Is Approve</th>
                                            <th>Reg. Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>First Name</th>
                                            <th> Last Name</th>
                                            <th> Email Id</th>
                                            <th>Is Approve</th>
                                            <th>Reg. Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                              <?php $ret=mysqli_query($con,"select * from users");
                              $cnt=1;
                              while($row=mysqli_fetch_array($ret))
                              {?>
                              <tr>
                              <td><?php echo $cnt;?></td>
                                  <td><?php echo $row['fname'];?></td>
                                  <td><?php echo $row['lname'];?></td>
                                  <td><?php echo $row['email'];?></td>
                                    <td>
                                        <form method="POST">
                                        <input type="hidden" value="<?php print($row['is_approve']==1? $status=0:$status=1);?>" name="is_approved">
                                        <input type="hidden" value="<?php echo $row['id'];?>" name="user_id">
                                        <button type="submit" onclick="return IsuserActive(<?php echo $status; ?>);" class="text-gray-500 btn btn-secondary btn-sm" name="approved_id"><?php print($row['is_approve']==1? 'Approved' :'Not Approved');?></button>
                                        </form>
                                    </td>
                                  <td><?php echo $row['posting_date'];?></td>
                                  <td>
                                     
                                     <a href="user-profile.php?uid=<?php echo $row['id'];?>"> 
                          <i class="fas fa-edit"></i></a>
                                     <a href="manage-users.php?id=<?php echo $row['id'];?>" onClick="return confirm('Do you really want to delete');"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                  </td>
                              </tr>
                              <?php $cnt=$cnt+1; }?>
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
  <?php include('../includes/footer.php');?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
        <script type="text/javascript">
            function IsuserActive(status_value){
            if (status_value == 1) {
                var user_status = "Approved";
            } else {
                var user_status = "Not Approved";
            }

            var del = confirm("Are you sure you want to " + user_status + " the user status ?");
            if (del == true) {
                alert("User record status is updated successfully")
            }
            return del;
            }
        </script>
    </body>
</html>
<?php } ?>
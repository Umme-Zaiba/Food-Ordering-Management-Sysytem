<?php include('partials/menu.php'); ?>

<div class="main-content">
   <div class="wrapper">
      <h1>Change Password</h1>
      <br><br>

      <?php 
       if(isset($_GET['id']))
       {
         $id=$_GET['id'];
       }
      ?>

      <form action="" method="POST">
         <table class="tbl_30">
            <tr>
               <td>Current Password:</td>
               <td>
                  <input type="password" name ="current_password" placeholder="Current password">
               </td>
            </tr>
            <tr>
               <td>New Password:</td>
               <td>
                  <input type="password" name ="new_password" placeholder="New Password">
               </td>
            </tr>
            <tr>
               <td>Confirm Password:</td>
               <td>
                  <input type ="password"  name ="confirm_password" placeholder="Confirm Password">
               </td>
            </tr>

            <tr>
               <td colspan="2">
                  <input type="hidden" name ="id" value="<?php echo $id; ?>">
                  <input type="submit" name ="submit" value="Change Password" class="btn-secondary">
               </td>
            </tr>

         </table>
      </form>

   </div>
</div>

<?php
         //check whether the submit button is clicked or not
   if(isset($_POST['submit']))
   {
      // echo "clicked";

      //1.get the data from the FORM
      $id=$_POST['id'];
      $current_password=md5($_POST['current_password']);
      $new_password=md5($_POST['new_password']);
      $confirm_password=md5($_POST['confirm_password']);

      //2.check whether the user with the current ID and current password exists or not 
      $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
         //execute the query
         $res=mysqli_query($conn,$sql);
         if($res==TRUE)
         {
            //check whether the data is available or not
            $count=mysqli_num_rows($res);

            if($count==1)
            {
               //user exits and password can be changed
               // echo 'user found';
               //check whether the new password and confirm password maps or not
               if($new_password==$confirm_password)
               {
                  //update the password
                  // echo "password matched";
                  $sql2="UPDATE tbl_admin SET
                  password='$new_password' 
                  WHERE id=$id
                  ";

                  //execute the query
                  $res= mysqli_query($conn,$sql);
                  //check whether the query is executed or not
                  if($res==TRUE)
                  {
                     //display success message
                     $_SESSION['change-pwd']="<div class='success'>password changed successfully</div>";
                     //redirect the user
                     header('location:'.SITEURL.'admin/manage-admin.php');
                  }
                  else{
                     //display error message
                     $_SESSION['change-pwd']="<div class='error'>failed to change password.</div>";
                     //redirect the user
                     header('location:'.SITEURL.'admin/manage-admin.php');
                  }
               }
               else{
                  //redirect to maange admin page with error message
                  $_SESSION['pwd-not-match']="<div class='error'>password didn't matched</div>";
                  //redirect the user
                  header('location:'.SITEURL.'admin/manage-admin.php');
               }
            }
            else{
               //user doesnt exits set message and redirect
               $_SESSION['user-not-found']="<div class='error'>User not found</div>";
               //redirect the user
               header('location:'.SITEURL.'admin/manage-admin.php');
            }
         }
   

      //3. check whether the new password and confirm password march or not

      //4.change password if all above is correct
   }
?>

<?php include('partials/footer.php'); ?>
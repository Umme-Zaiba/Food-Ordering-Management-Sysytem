<?php
   //include constants file
   include('../config/constants.php');

   //echo  "Delete Page";
   //check whether the id and image_name is set r not 
   if(isset($_GET['id'])AND isset($_GET['image_name']))
   {
      //get the value and delete
         //echo "Get value and Delete";
         $id=$_GET['id'];
         $image_name=$_GET['image_name'];

      //remove the physical image-file if available 
         if($image_name!="")
         {
            //Image is available then remove it
            $path="../images/category/".$image_name;

            //remove the image
            $remove=unlink($path);
            
            //if failed to remove the image
            if($remove==FALSE)
            {
               //set the session message
               $_SESSION['remove']="<div class='error'>Failed to remove the message.</div>";
               //redirect to manage category page 
               header('location:'.SITEURL.'admin/manage-category.php');
               //stop the process
               die();
            }
         }
      //delete data from database
       //sql query to delete data from database
         $sql="DELETE FROM tbl_category WHERE id=$id";
         //execute the query
         $res=mysqli_query($conn,$sql);
         //check whether the data is deleted from the database
         if($res==TRUE)
         {
            //SET success message and redirect
            $_SESSION['delete']="<div class='success'>Deleted Successfully</div>";
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
         }
         else
         {
            //set fail message and redirect
            $_SESSION['delete']="<div class='error'>Failed to Delete</div>";
            //redirect to manage category
            header('location:'.SITEURL.'admin/manage-category.php');
         }
      //redirect to manage-category page with message
      

   }
   else
   {
      //redirect to category manage page
      header('location:'.SITEURL.'admin/manage-category.php');
   }
?>
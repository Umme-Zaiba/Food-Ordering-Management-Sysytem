<?php 

   include('../config/constants.php');

   if(isset($_GET['id'])&& isset($_GET['image_name']))         //either use &&  or AND
   {
      //proceed to delete
      // echo "process to delete";

      //1.get the id and image name
      $id=$_GET['id'];
      $image_name=$_GET['image_name'];

      //2.remove the image if available
         //check whether the image is available ot not
         if($image_name!="")
         {
            //has image and need to remove
            //get the image path
            $path='../images/food/'.$image_name;
            //remove the file from the folder
            $remove=unlink($path);

            //check whether the image is removed or not
            if($remove==FALSE)
            {
               //error and redirect to manage food page
               $_SESSION['upload']="<div class='error'>Failed to remove the image file</div>";
               header('location:'.SITEURL.'admin/manage-food.php');
               die(); //stop the process
            }
            
         }

      //3.delete food from database
      $sql="DELETE FROM tbl_food WHERE  id=$id";
      //execute the query
      $res=mysqli_query($conn,$sql);
      //check whether the query is executed or not
      if($res==TRUE)
      {
         //food deleted
         $_SESSION['delete']="<div class='success'>deleted food successfully.</div>";
         header('location:'.SITEURL.'admin/manage-food.php');
      }
      else
      {
         //failed to delete food
         $_SESSION['delete']="<div class='error'>Failed to remove food</div>";
               header('location:'.SITEURL.'admin/manage-food.php');
      }

      //4.redirect to manage food page.
   }
   else 
   {
      //redirect to manage food page
      //echo "redirect";
      $_SESSION['unauthorize']="<div class='error'>Uauthorised access</div>";
      header('location:'.SITEURL.'admin/manage-food.php');
   }

?>
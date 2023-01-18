<?php include('partials/menu.php');?>
<div class="main-content">
   <div class="wrapper">
      <h1>Update Category</h1>

         <br><br>

         <?php         
            //check whether the id is set or not
            if(isset($_GET['id']))
            {
               //get the id and get all the details
               // echo "Getting the data";
               $id=$_GET['id'];
               //create sql query to get all other details
               $sql="SELECT  * FROM tbl_category WHERE id=$id";
               //exceute the query
               $res=mysqli_query($conn,$sql);
               //count the rows to check if the id is valid or not
               $count=mysqli_num_rows($res);

               if($count==1)
               {
                  //get the data
                  $row=mysqli_fetch_assoc($res);
                  $title=$row['title'];
                  $current_image=$row['image_name'];
                  $featured=$row['featured'];
                  $active=$row['active'];
               }
               else
               {
                  //redirect to manage - category page
                  $_SESSION['no-cateory-found']="<div class='error'>category not found</div>";
                  header('location:'.SITEURL.'admin/manage-category.php');
               }
            }
            else
            {
               //redirect to manage-category page
               header('location:'.SITEURL.'admin/manage-category.php');
            }
         ?>

         <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
               <tr>
                  <td>Title:</td>
                  <td>
                     <input type="text" name="title" value="<?php echo $title;?>">
                  </td>
               </tr>
               <tr>
                  <td>Current image:</td>
                  <td>
                    <?php
                      if($current_image!="")
                      {
                        //display the image
                        ?>
                           <img src="<?php echo SITEURL;?>images/category/<?php echo $current_image;?>"width="150px">
                        <?php
                      }
                      else
                      {
                        //display error message
                        echo "<div class='error'>Image was not added!</div>";
                      }
                    ?>
                  </td>
               </tr>
               <tr>
                  <td>New Image:</td>
                  <td>
                     <input type="file" name ="image">
                  </td>
               </tr>
               <tr>
                  <td>Featured:</td>
                  <td>
                     <input <?php if($featured=="Yes"){echo "checked";}?>  type="radio" name="featured" value="Yes">Yes

                     <input <?php if($featured=="No"){echo "checked";}?> type="radio" name="featured" value="No">No
                  </td>
               </tr>
               <tr>
               <td>Active:</td>
                  <td>
                     <input <?php if($active=="Yes"){echo "checked";}?> type="radio" name="active" value="Yes">Yes

                     <input <?php if($active=="No"){echo "checked";}?> type="radio" name="active" value="No">No
                  </td>
               </tr>
               <tr>
                  <td>
                     <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                     <input type="hidden" name="id" value="<?php echo $id;?>">
                     <input type="submit" name ="submit" value="update category" class="btn-secondary">
                  </td>
               </tr>
            </table>
         </form>
         <?php
            if(isset($_POST['submit']))
            {
               // echo "clicked";
               //1.get the values from the form
               $id=$_POST['id'];
               $title=$_POST['title'];
               $current_image=$_POST['current_image'];
               $featured=$_POST['featured'];
               $active=$_POST['active'];
               
            //2.update new image if selected
            //check whether the image is selected or not
            if(isset($_FILES['image']['name']))
            {
               //get the image details
               $image_name=$_FILES['image']['name'];
               //check whether the image is available or not
               if($image_name!="")
               {
                  //A.Image available 
                  //upload the image
                   //auto rename our image
                        //get the extension of image(jpg,jpeg,png,gif,etc) eg: "specialfood1.jpg"
                        $ext=end(explode('.',$image_name));

                        //rename the image
                        $image_name="Food_Category_".rand(000,999).'.'.$ext; //eg. Food_Category_834.jpg
                        
                        $source_path=$_FILES['image']['tmp_name'];

                        $destination_path="../images/category/".$image_name;
                        //finally upload the image
                        $upload= move_uploaded_file($source_path,$destination_path);

                        //check whether our image is uploaded or not
                        //and if the image is not uploaded then we will stop the process and redirect with the message
                        if($upload==FALSE)
                        {
                           //set message
                           $_SESSION['upload']="<div class='error'> Failed to upload the image</div>";
                           //redirect to add category page
                           header('location:'.SITEURL.'admin/manage-category.php');
                           //stop the process
                           die();
                        }
                  //B.remove the current image if available
                  if($current_image!="")
                  {
                     $remove_path="../images/category/".$current_image;

                     $remove=unlink($remove_path);
   
                     //check whetherthe image is removed or not
                     //if failed to remove then display message and stop the process
                     if($remove==FALSE)
                     {
                        //failed to remove the image
                        $_SESSION['failed-remove']="<div class='error'> Failed to remove the image</div>";
                              //redirect to add category page
                        header('location:'.SITEURL.'admin/manage-category.php');
                        die();//stop the process
   
                     }
                  }                       
               }
               else
               {
                  $image_name=$current_image;
               }
            }
            else
            {
               $image_name=$current_image;
            }
            //3.update the database
            $sql2="UPDATE tbl_category SET
               title='$title',
               image_name='$image_name',
               featured='$featured',
               active='$active'
               WHERE id=$id
            ";
            //execute the query
            $res2=mysqli_query($conn,$sql2);
            
            //4.redirect to manage-category page with message
             //check whether thequery is excuted or not 
            if($res==TRUE)
            {
               //updated category
               $_SESSION['update']="<div class='success'>category updated successfully</div>";
               header('location:'.SITEURL.'admin/manage-category.php');
               
            }
            else
            {
               //failed to update category
               $_SESSION['update']="<div class='error'>failed to updated category! </div>";
               header('location:'.SITEURL.'admin/manage-category.php');
            }
            }
                    
         ?>
</div>
</div>
<?php include('partials/footer.php');?>
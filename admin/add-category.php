<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
         <br><br>

         <?php
         
         if(isset($_SESSION['add']))
         {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
         }
         if(isset($_SESSION['upload']))
         {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
         }

         ?>

         <br><br>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                  <tr>
                     <td>Select image:  </td>
                     <td>
                        <input type="file" name="image">
                     </td>
                  </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes 
                        <input type="radio" name="featured" value="No"> No 
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes 
                        <input type="radio" name="active" value="No"> No 
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Add Category Form Ends -->

        <?php
            //check whether the submit button is clicked or not
            if(isset($_POST['submit']))
            {
               // echo "clicked";

               //1.get the value from the form
               $title=$_POST['title'];
               //for radio input, we need to check whether the button is selected or not 
               if(isset($_POST['featured']))
               {
                  //Get the value from the form
                  $featured=$_POST['featured'];
               }
               else
               {
                  //Set the default value
                  $featured="No";
               }
               if(isset($_POST['active']))
               {
                  //get the value from the form
                  $active=$_POST['active'];
               }
               else
               {
                  $active="No";
               }

               //check whether the iamge is selected or not and set the value for image name accordingly
                     //print_r($_FILES['image']);

                     //die(); //break the code here
                  if(isset($_FILES['image']['name']))
                  {
                        //upload the image
                        //to upload the image we need two things, i.e, image name ,source path and destination path
                        $image_name=$_FILES['image']['name'];

                        //upload image only if image is selected
                     if($image_name!="")
                     {
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
                           header('location:'.SITEURL.'admin/add-category.php');
                           //stop the process
                           die();
                        }
                     }
                  }
                  else
                  {
                     //don't upload image and set the image_name value as blank
                     $image_name="";
                  }

                  //2.Create sql query to insert the category into the database
                  $sql="INSERT INTO tbl_category SET
                     title='$title',
                     image_name='$image_name',
                     featured='$featured',
                     active='$active'
                  ";
                  //3.execute the query and save into the database
                  $res=mysqli_query($conn,$sql);

                  //4.check whether the query is executed or not 
                  if($res==TRUE)
                  {
                     //query executed and category added 
                     $_SESSION['add']="<div class ='success'>Category added successfully</div>";
                     //redirect to manage category page
                     header('location:'.SITEURL.'admin/manage-category.php');
                  }
                  else{
                     //failed to add category
                     $_SESSION['add']="<div class ='error'>Failed to add Category</div>";
                     //redirect to manage category page
                     header('location:'.SITEURL.'admin/manage-category.php');
                  }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
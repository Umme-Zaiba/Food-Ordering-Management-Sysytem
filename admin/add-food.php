<?php include('partials/menu.php');?>
<div class="main-content">
   <div class="wrapper">
      <h1>Add Food</h1>
      <br><br>
      <?php
      
         if(isset($_SESSION['upload']))
         {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
         }

      ?>
<br><br>
      <form action="" method="POST" enctype="multipart/form-data">
         <table class="tbl-30">
            <tr>
               <td>Title: </td>
               <td>
                  <input type="text" name="title" placeholder="Title of the food">
               </td>
            </tr>
            <tr>
               <td>Description: </td>
               <td>
                  <textarea name="description"  cols="30" rows="5"placeholder="Description of the food."></textarea>
               </td>
            </tr>
            <tr>               
               <td>Price: </td>
               <td>
                  <input type="number" name="price">
               </td>
            </tr>
            <tr>
               <td>Select image: </td>
               <td>
                  <input type="file" name="image" >
               </td>
            </tr>
            <tr>
               <td>Category: </td>
               <td>
                  <select name="category">

                     <?php
                        //create php code to display the categories from databse
                        //1.create SQL to get all the active categories from database
                        $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                        //execute the query
                        $res=mysqli_query($conn,$sql);
                        //count rows to check whether we have categories or not
                        $count=mysqli_num_rows($res);

                        //if count is greater than zero we have categories else we dont have categories
                        if($count>0)
                        {
                           //ADD categories
                           while($row=mysqli_fetch_assoc($res))
                           {
                              //get the details of the category 
                              $id=$row['id'];
                              $title=$row['title'];  
                              ?>
                               <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                              <?php                            
                           }
                        }
                        else
                        {
                           //we do not have the categories
                         ?>

                         <option value="0">No Category found.</option>
                         <?php
                          
                        }

                        //2.Display a Dropdown
                     ?>
                     
                     </select>
               </td>
            </tr>
            <tr>
               <td>Featured:</td>
               <td>
                  <input type="radio" name ="featured" value="Yes">Yes
                  <input type="radio" name ="featured" value="No">No
               </td>
            </tr> 
            <tr>
               <td>Active:</td>
               <td>
                  <input type="radio" name ="active" value="Yes">Yes
                  <input type="radio" name ="active" value="No">No
               </td>
            </tr> 
            <tr>
               <td colspan="2">
                  <input type="submit" name="submit" value="Add food" class="btn-secondary">
               </td>
            </tr>            
         </table>
      </form>
      <?php 
      
      //check whether the button is clicked or not 
      if(isset($_POST['submit']))
      {
         //add the food in database
         // echo "clicked";
         //1.GEt the data from form and then 
            $title=$_POST['title'];
            $description=$_POST['description'];
            $price=$_POST['price'];
            $category=$_POST['category'];
            
            //check whether the radio button is clicked or not
            if(isset($_POST['featured']))
            {
               $featured=$_POST['featured'];
            }
            else
            {
               $featured="No"; //setting the default
            }
            if(isset($_POST['active']))
            {
               $active=$_POST['active'];
            }
            else
            {
               $active="No";
            }

         //2.Upload the image if selected
            //check whether the select image is clicked or not andupload the image only is image is seleted
               if(isset($_FILES['image']['name']))
               {
                  //get the details of the selected image
                     $image_name=$_FILES['image']['name'];

                     //check whether the image is slected or not and upload hthe image only if slected.
                     if($image_name!="")
                     {
                        //image is selected
                        //A.Rename the image
                           //get the extension of the selected image  eg.zai-ba.jpg
                           $ext=end(explode('.',$image_name));
                           //create new name for image
                           $image_name="food-Name-".rand(0000,9999).".".$ext;  //eg: food-Name-438.ext
                        //B.Upload the image
                           //get the source path and destination path.
                           //Source path is the current location of the image
                           $src=$_FILES['image']['tmp_name'];
                           //destimation path for the mage to be uploaded
                           $dst="../images/food/".$image_name;
                          //finally upload the image
                          $upload=move_uploaded_file($src,$dst); 
                          //check whether the image is uploded or not
                          if($upload==FALSE)
                          {
                           //failed to upload image
                           //redirect to add food page eith error message
                           $_SESSION['upload']="<div class='error'>Failed to upload image.</div>";
                           header('location:'.SITEURL.'admin/add-food.php');
                           //stop the process
                           die();
                          }

                     }
                  
               }
               else
               {
                  $image_name=""; //setting default as blank.
               }
         //3.Insert into database
               //create a sql query to add food
               $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";
               //execute the  query
               $res2=mysqli_query($conn,$sql2);
               //check whether the data is inseerted or not
               if($res2==TRUE)
               {
                  //data inserted successfully
                  $_SESSION['add']="<div class='success'>Food added Successfully!</div>";
                  header('location:'.SITEURL.'admin/manage-food.php');
               }
               else
               {
                  //failed to insert the data
                  $_SESSION['add']="<div class='error'>Failed to add Food<div>";
                  header('location:'.SITEURL.'admin/manage-food.php');
               }

         //4.redirect to manage-food page
      }

      ?>
   </div>
</div>
<?php include('partials/footer.php');?>
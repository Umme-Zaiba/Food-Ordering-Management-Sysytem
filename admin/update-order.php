<?php include('partials/menu.php')?>
   <div class="main-content">
      <div class="wrapper">
         <h1>Update Order</h1>
         <br><br>
         <?php
            //check whether id is set or not
            if(isset($_GET['id']))
            {
               //get the order details
               $id=$_GET['id'];
               //get the details based on id i.e query
               $sql="SELECT * FROM tbl_order WHERE id=$id";
               $res=mysqli_query($conn,$sql);
               $count=mysqli_num_rows($res);
               if($count==1)
               {
                  //data available
                  $row=mysqli_fetch_assoc($res);
                  $food=$row['food'];
                  $price=$row['price'];
                  $qty=$row['qty'];
                  $status=$row['status'];
               }
               else
               {
                  //data not available
                  header('location:'.SITEURL.'admin/manage-order.php');
               }
            }
            else
            {
               //redirect to manage order page
               header('location:'.SITEURL.'admin/manage-order.php');
            }
         ?>

         <form action="" method="POST">
            <table class="tbl-30">
               <tr>
                  <td>Food Name :</td>
                  <td style="text-transform:uppercase"><b><?php echo $food; ?></b></td>
               </tr>
               <tr>
                  <td>Price :</td>
                  <td>$<?php echo $price;?></td>
               </tr>
               <tr>
                  <td>Qty :</td>
                  <td>
                     <input type="number" name="qty" value="">
                  </td>
               </tr>
               <tr>
                  <td>Status : </td>
                  <td>
                     <select name="status">
                        <option <?php if($status=="Ordered"){echo "selected";}?> value="Ordered">Ordered</option>
                        <option <?php if($status=="On Delivery"){echo "selected";}?> value="On Delivery">On Delivery</option>
                        <option <?php if($status=="Delivered"){echo "selected";}?>value="Delivered">Delivered</option>
                        <option <?php if($status=="Canceled"){echo "selected";}?> value="Canceled">Canceled</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td colspan ="2">
                     <input type="hidden" name="id" value="<?php echo $id;?>">
                     <input type="hidden" name="price" value="<?php echo $price;?>">
                     <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                  </td>
               </tr>
            </table>
         </form>
            <?php
            //check whether the update button is clicked or not
            if(isset($_POST['submit']))
            {
              // echo "Clicked";
              //get all the values form the form
              $id=$_POST['id'];
            //   $price=$_POST['price'];
            //   $qty=$_POST['qty'];
            //   $total = $price * $qty;
              $status=$_POST['status'];

              //update the values
              $sql2="UPDATE tbl_order SET
             
               status='$status'
               WHERE id=$id
              ";
             $res2=mysqli_query($conn,$sql2);
              //check whether query is executed or not
              if($res2==true)
              {
               //updated
               $_SESSION['update']="<div class='success'>Order updated Successfully!</div>";
               header('location:'.SITEURL.'admin/manage-order.php');
              }
              else
              {
               //failed to update
               $_SESSION['update']="<div class='error'>Failed to update order!</div>";
               header('location:'.SITEURL.'admin/manage-order.php');
              }

              //redirect to manage order with message
            }
            ?>
      </div>
   </div>
<?php include('partials/footer.php')?>
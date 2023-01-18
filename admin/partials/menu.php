<!-- //created constant page , but we will have to include constant.php file in every page related to admin 
//so instead of including in every page we will write in menu.php which is already included in every file related to admin -->
<?php 
   include('../config/constants.php');
   include('login-check.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Food Order Website - Home Page</title>
   <link rel="stylesheet" href="../css/admin.css">
   <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk&display=swap" rel="stylesheet">
</head>
<body>
   <!-- Menu section starts -->
   <div class="menu text-center">
      <div class="wrapper">
     <ul>
         <li><a href="index.php" class="hover-animation">Home</a></li>
         <li><a href="manage-admin.php" class="hover-animation">Admin</a></li>
         <li><a href="manage-category.php" class="hover-animation">Category</a></li>
         <li><a href="manage-food.php" class="hover-animation">Food</a></li>
         <li><a href="manage-order.php" class="hover-animation">Order</a></li>
         <li><a href="logout.php" class="hover-animation">Logout</a></li>
     </ul>
      </div>
      
   </div>
   <!-- Menu section ends -->
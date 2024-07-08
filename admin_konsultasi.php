<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `konsultasi` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'Konsultasi name already exists!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `konsultasi`(name, details, price, image) VALUES('$name', '$details', '$price', '$image')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'Image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'Konsultasi added successfully!';
         }
      }
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `konsultasi` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `konsultasi` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_konsultasi.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom Admin CSS File Link -->
   <link rel="stylesheet" href="css/admin_style.css">

   <style>
      /* Styling for the product table */
      .table-container {
         width: 100%;
         overflow-x: auto;
      }
      table {
         width: 100%;
         border-collapse: collapse;
      }
      table th, table td {
         padding: 10px;
         text-align: left;
         border-bottom: 1px solid #ddd;
         font-size: 18px;
      }
      table th {
         background-color: #f2f2f2;
      }
      .product-image {
         max-width: 100px;
         height: auto;
      }
      .empty {
         text-align: center;
         padding: 10px;
      }
   </style>

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-products">
   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add New Konsultasi</h3>
      <input type="text" class="box" required placeholder="Enter konsultasi name" name="name">
      <input type="number" min="0" class="box" required placeholder="Enter konsultasi price" name="price">
      <textarea name="details" class="box" required placeholder="Enter konsultasi details" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="Add Konsultasi" name="add_product" class="btn">
   </form>
</section>

<section class="show-products">
   <div class="table-container">
      <table>
         <thead>
            <tr>
               <th style="text-align: center;">Image</th>
               <th style="text-align: center;">Name</th>
               <th style="text-align: center;">Details</th>
               <th style="text-align: center;">Price</th>
               <th style="text-align: center;">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               $select_products = mysqli_query($conn, "SELECT * FROM `konsultasi`") or die('query failed');
               if(mysqli_num_rows($select_products) > 0){
                  while($fetch_products = mysqli_fetch_assoc($select_products)){
            ?>
            <tr>
               <td style="text-align: center;"><img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="product-image"></td>
               <td style="text-align: center;"><?php echo $fetch_products['name']; ?></td>
               <td style="text-align: center;"><?php echo $fetch_products['details']; ?></td>
               <td style="text-align: center;">Rp<?php echo number_format($fetch_products['price'], 0, ',', '.'); ?></td>
               <td style="text-align: center;">
                  <a href="admin_update_konsultasi.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Update</a>
                  <a href="admin_konsultasi.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this konsultasi?');">Delete</a>
               </td>
            </tr>
            <?php
                  }
               } else {
                  echo '<tr><td colspan="5" class="empty">No products added yet!</td></tr>';
               }
            ?>
         </tbody>
      </table>
   </div>
</section>

<script src="js/admin_script.js"></script>

</body>
</html>

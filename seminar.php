<?php

@include 'config.php';

session_start();

// if (isset($_POST['add_to_cart'])) {

//     $product_id = $_POST['seminar_id'];
//     $product_name = $_POST['seminar_name'];
//     $product_image = $_POST['seminar_image'];

//     $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

//     if (mysqli_num_rows($check_cart_numbers) > 0) {
//         $message[] = 'Already added to cart';
//     } else {
//         mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, image) VALUES('$user_id', '$product_id', '$product_name', '$product_image')") or die('query failed');
//         $message[] = 'Product added to cart';
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Seminar</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>our seminar</h3>
    <p> <a href="home.php">Home</a> / Seminar </p>
</section>

<section class="products">

   <h1 class="title">seminar</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `seminar`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <input type="hidden" name="seminar_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="seminar_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="seminar_image" value="<?php echo $fetch_products['image']; ?>">
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No seminar added yet!</p>';
      }
      ?>

   </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>

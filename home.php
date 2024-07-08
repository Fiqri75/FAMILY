<?php

@include 'config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// if(!$user_id){
//    header('location:login.php');
//    exit();
// }

// if(isset($_POST['add_to_wishlist'])){

//    $product_id = $_POST['product_id'];
//    $product_name = $_POST['product_name'];
//    $product_price = $_POST['product_price'];
//    $product_image = $_POST['product_image'];
   
//    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

//    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

//    if(mysqli_num_rows($check_wishlist_numbers) > 0){
//        $message[] = 'already added to wishlist';
//    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
//        $message[] = 'already added to cart';
//    }else{
//        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
//        $message[] = 'product added to wishlist';
//    }

// }
try {
   if(isset($_POST['add_to_cart'])){
      $expiredDay=0;
      if(isset($_POST['product_id'])) {
         $product_id = $_POST['product_id'];
         $product_name = $_POST['product_name'];
         $product_price = $_POST['product_price'];
         $product_image = $_POST['product_image'];
         $selectProduct = mysqli_query($conn, "SELECT expired_day FROM `products` WHERE id = '$product_id' LIMIT 1") or die('query failed');
         if(mysqli_num_rows($selectProduct) > 0){
            while($fetchProd = mysqli_fetch_assoc($selectProduct)){
               $expiredDay = $fetchProd['expired_day'];
            }
         }
      }  elseif(isset($_POST['konsultasi_id'])) {
         $product_id = $_POST['konsultasi_id'];
         $product_name = $_POST['konsultasi_name'];
         $product_price = $_POST['konsultasi_price'];
         $product_image = $_POST['konsultasi_image'];
      }
   
      $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   
      if(mysqli_num_rows($check_cart_numbers) > 0){
          $message[] = 'Already added to cart';
      }else{
   
          $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   
          if(mysqli_num_rows($check_wishlist_numbers) > 0){
              mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
          }
   
          mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, image, expired_day) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$expiredDay')") or die('query failed');
          $message[] = 'Product added to cart';
      }
   
   }
} catch (\Throwable $th) {
   die($th->getMessage().' '. $th->getLine());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Best Parenting Solutions</h3>
      <p>The trusted source for all your parenting needs. We provide a variety of informative videos and consultation services from experts to help you on your parenting journey. Find comprehensive guidance on child development, strategies to overcome daily challenges, and how to build effective communication within the family.</p>
      <a href="about.php" class="btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">Seminar</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM seminar LIMIT 3") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name" style="font-weight: 550;"><?php echo $fetch_products['name']; ?></div>
         <input type="hidden" name="seminar_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="seminar_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="seminar_image" value="<?php echo $fetch_products['image']; ?>">
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="seminar.php" class="option-btn">load more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">subscription</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 3") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
         <div class="price">Rp<?php echo number_format($fetch_products['price'], 0, ',', '.'); ?></div>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name" style="font-weight: 550;"><?php echo $fetch_products['name']; ?></div>
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">No products added yet!</p>';
         }
      ?>

   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">consulting</h1>

   <div class="box-containers row-admin">
   <div class="col-6-admin">
     <img src="images/orang.jpg" alt="" style="width: 100%;">
     </div> 
      <div class="col-6-admin" style="padding-left: 30px;">
     <p style="margin-top: auto; margin-bottom: auto; color: var(--light-color); line-height: 2; font-size: 17.8px;">Are you facing parenting challenges and need the right guidance? We are here to help! Our parenting consultation service is specifically designed to provide practical solutions and impactful advice, tailored to your family's unique needs. With the support of experienced and trained experts, we will be with you every step of the way, from addressing your child's behavioral issues, to developing social skills, to building effective communication between parents and children. Make your parenting experience more enjoyable and meaningful with our help. Gain valuable insights and proven effective strategies to create a harmonious and loving environment in your home. Contact us now and start the journey towards better parenting!</p>
     </div>
     
   </div>

   <div class="more-btn">
      <a href="konsultasi.php" class="option-btn">order now</a>
   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>We've got you covered! If you have any questions, need a consultation, or want to find out more about our services, feel free to contact us. Our friendly and professional team will be happy to provide you with the answers and support you need. Please fill out the form below, or contact us via email or phone number provided. We will respond promptly to each of your messages. Thank you for contacting us!</p>
      <a href="contact.php" class="btn">contact us</a>
   </div>

</section>

<?php @include 'footer.php'; ?>
<?php @include 'message.php'; ?>

<script src="js/script.js"></script>

</body>
</html>

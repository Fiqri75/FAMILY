<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quick View</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="quick-view">

    <h1 class="title">details</h1>

    <?php
        if(isset($_GET['pid'])){
            $pid = $_GET['pid'];

            // Check if the product is from products table
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_products = mysqli_fetch_assoc($select_products)){
                    $product_price = isset($fetch_products['price']) ? floatval($fetch_products['price']) : 0;
    ?>
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">Rp<?php echo number_format($product_price, 0, ',', '.'); ?></div>
         <div class="details"><?php echo $fetch_products['details']; ?></div>
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      </form>
    <?php
                }
            }

            // Check if the product is from konsultasi table
            $select_konsultasi = mysqli_query($conn, "SELECT * FROM `konsultasi` WHERE id = '$pid'") or die('query failed');
            if(mysqli_num_rows($select_konsultasi) > 0){
                while($fetch_products = mysqli_fetch_assoc($select_konsultasi)){
                    $product_price = isset($fetch_products['price']) ? floatval($fetch_products['price']) : 0;
    ?>
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">Rp<?php echo number_format($product_price, 0, ',', '.'); ?></div>
         <div class="details"><?php echo $fetch_products['details']; ?></div>
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      </form>
    <?php
                }
            }

            // Check if the product is from seminar table
            $select_seminar = mysqli_query($conn, "SELECT * FROM `seminar` WHERE id = '$pid'") or die('query failed');
            if(mysqli_num_rows($select_seminar) > 0){
                while($fetch_products = mysqli_fetch_assoc($select_seminar)){
                    $product_price = isset($fetch_products['price']) ? floatval($fetch_products['price']) : 0;
    ?>
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image" style="max-width: 100%; height: auto;">
         <div class="name" style="font-weight: bold;"><?php echo $fetch_products['name']; ?></div>
         <div class="price">Rp. <?php echo number_format($product_price, 0, ',', '.'); ?></div> <!-- Harga pertama -->
         <div class="location" style="font-size: 18px; padding-top: 10px;">Location : <?php echo $fetch_products['location']; ?></div> <!-- Lokasi kedua -->
         <div class="time" style="font-size: 18px; padding-top: 10px;">Time : <?php echo $fetch_products['time']; ?></div> <!-- Waktu ketiga -->
         <div class="contact" style="font-size:18px; padding-top: 10px;">Contact Person : <?php echo $fetch_products['contact']; ?></div>
         <div class="details" style="font-size:18px;"><?php echo $fetch_products['details']; ?></div> <!-- Detail keempat -->
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_time" value="<?php echo $fetch_products['time']; ?>"> <!-- Menambahkan waktu ke input hidden -->
         <input type="hidden" name="product_location" value="<?php echo $fetch_products['location']; ?>"> <!-- Menambahkan lokasi ke input hidden -->
         <input type="hidden" name="product_contact" value="<?php echo $fetch_products['contact']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      </form>
    <?php
                }
            }

        }
    ?>

    <div class="more-btn">
        <a href="home.php" class="option-btn">go to home page</a>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>

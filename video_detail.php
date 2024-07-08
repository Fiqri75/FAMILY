<?php

@include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];

// if (!isset($user_id)) {
//     header('location:login.php');
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Video</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .video {
   width: 100%;
   height: auto;
   object-fit: cover;
      }

      .box {
         width: 100%;
         max-width: 400px; /* Atur sesuai kebutuhan Anda */
         margin: 0 auto;
         padding: 15px;
         box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
         border-radius: 10px;
         background-color: #fff;
         overflow: hidden;
         text-align: center;
      }
   </style>
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>our video</h3>
    <p> <a href="home.php">Home</a> / Video </p>
</section>

<section class="products">

   <h1 class="title">video</h1>

   <div class="box-container">

      <?php
         $kategori = $_GET['kategori'];
         $select_products = mysqli_query($conn, "SELECT * FROM `video` WHERE kategori = '$kategori'") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            $i=1;
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
               if($i <=1 || $isPremium) {
      ?>
      
      <form action="" method="POST" class="box card-video">
      <video src="uploaded_videos/<?php echo $fetch_products['video']; ?>" controls poster="uploaded_img/<?php echo $fetch_products['image']; ?>" class="video"></video>
      <div class="name" style="font-weight: 550;"><?php echo $fetch_products['name']; ?></div>
         <input type="hidden" name="video_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="video_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="video_image" value="<?php echo $fetch_products['video']; ?>">
      </form>
      <?php
         } else {
      ?>
       <form action="" method="POST" class="box card-video card-video-unlock">
         <i class="fa-solid fa-lock" style="font-size: 100px; font: 'Roboto'"></i>
         <div class="name">Akun Anda harus <span style="color: #FFA500; font-weight: bold;">Premium</span> jika ingin membuka Video ini</div>
      </form>
      <?php
         }
            $i++;
         }
      }
      ?>

   </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>

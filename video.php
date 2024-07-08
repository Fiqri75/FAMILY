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
   <title>Playlist</title>

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
    <h3>our playlist</h3>
    <p> <a href="home.php">Home</a> / Playlist </p>
</section>

<section class="products">

   <h1 class="title">playlist</h1>

   <div class="box-container">

   <form action="video_detail.php" method="GET" class="box card-video">
      <h1 style="font-size: 18px;">CARA MEMPERLAKUKAN BALITA DENGAN BENAR</h1>
      <img src="images/balita.jpg" alt="" style="width: 100%; border-radius: 0.5rem; padding-top: 10px;">
      <input type="hidden" name="kategori" value="balita"/>
      <input type="submit" value="View Playlist" class="btn"/>
   </form>
   <form action="video_detail.php" method="GET" class="box card-video">
      <h1 style="font-size: 18px;">CARA MENDIDIK ANAK YANG SUDAH BERUMUR 7 TAHUN</h1>
      <img src="images/anak7tahun.jpg" alt="" style="width: 100%; border-radius: 0.5rem; padding-top: 10px;">
      <input type="hidden" name="kategori" value="anak_7_tahun"/>
      <input type="submit" value="View Playlist" class="btn"/>
   </form>
   <form action="video_detail.php" method="GET" class="box card-video">
      <h1 style="font-size: 18px;">PELAJARI INI SEBELUM KAMU MENIKAH</h1>
      <img src="images/pelajari.jpg" alt="" style="width: 100%; border-radius: 0.5rem; padding-top: 10px;">
      <input type="hidden" name="kategori" value="pelajari"/>
      <input type="submit" value="View Playlist" class="btn"/>
   </form>

   </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>

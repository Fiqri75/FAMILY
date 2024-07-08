<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

   mysqli_query($conn, "UPDATE `video` SET name = '$name', details = '$details', kategori = '$kategori' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['update_p_image'];

   if(isset($_FILES['video'])){
      $video = $_FILES['video']['name'];
      $video_size = $_FILES['video']['size'];
      $video_tmp_name = $_FILES['video']['tmp_name'];
      $video_folder = 'uploaded_videos/' . $video;
   } else {
      $video = '';
      $video_size = 0;
      $video_tmp_name = '';
      $video_folder = '';
   }

   $old_video = $_POST['update_p_video'];

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image file size is too large!';
      }else{
         mysqli_query($conn, "UPDATE `video` SET image = '$image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('uploaded_img/'.$old_image);
         $message[] = 'Image updated successfully!';
      }
   }

   if(!empty($video)){
      if($video_size > 20000000){
         $message[] = 'video file size is too large!';
      }else{
         mysqli_query($conn, "UPDATE `video` SET video = '$video' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($video_tmp_name, $video_folder);
         unlink('uploaded_videos/'.$old_video);
         $message[] = 'Video updated successfully!';
      }
   }

   $message[] = 'Video updated successfully!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="update-product">

<?php

   $update_id = $_GET['update'];
   $select_products = mysqli_query($conn, "SELECT * FROM `video` WHERE id = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>

<form action="" method="post" enctype="multipart/form-data">
   <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="image" alt="" width="400">
   <video src="uploaded_videos/<?php echo $fetch_products['video']; ?>" class="product-video" controls width="400"></video>
   <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id">
   <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">
   <input type="hidden" value="<?php echo $fetch_products['video']; ?>" name="update_p_video">
   <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="update product name" name="name">
   <textarea name="details" class="box" required placeholder="update product details" cols="30" rows="10"><?php echo $fetch_products['details']; ?></textarea>
   <h2 style="font-size: 18px;">IMAGE</h2>
   <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
   <h2 style="font-size: 18px;">VIDEO</h2>
   <input type="file" accept="video/mp4, video/avi, video/mkv" class="box" name="video">
   <select name="kategori" id="" style="font-weight: 600; font-size: 16px; text-align: center;" class="box">
            <option value="balita" <?php echo $fetch_products['kategori'] == 'balita' ? 'selected' : '' ?>>CARA MEMPERLAKUKAN BALITA DENGAN BENAR</option>
            <option value="anak_7_tahun" <?php echo $fetch_products['kategori'] == 'anak_7_tahun' ? 'selected' : '' ?>>CARA MENDIDIK ANAK YANG BERUMUR 7 TAHUN</option>
            <option value="pelajari" <?php echo $fetch_products['kategori'] == 'pelajari' ? 'selected' : '' ?>>PELAJARI INI SEBELUM KAMU MENIKAH</option>
   </select>
   <input type="submit" value="update product" name="update_product" class="btn">
   <a href="admin_video.php" class="option-btn">go back</a>
</form>

<?php
      }
   }else{
      echo '<p class="empty">No update video selected</p>';
   }
?>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>

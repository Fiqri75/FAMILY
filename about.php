<?php

@include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];

// if(!isset($user_id)){
//    header('location:login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <p> <a href="home.php">Home</a> / About </p>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/keluarga.jpg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>Because we understand how important your role as a parent is and how challenging it is to parent a child in this modern era. Our website offers consultations that are not only based on theory, but also real-life experiences from dedicated parenting experts. We provide a personalized and tailored approach to each family's unique situation, ensuring the solutions we offer are relevant and effective. With access to a range of exclusive resources, informative articles and a supportive community, we ensure you get the holistic support you need. Choose us because we are committed to helping you become a more confident parent who is ready to face the challenges of parenting with love and confidence. With us, you not only get solutions, but also inspiration to create a harmonious and happy family environment.</p>
            <a href="shop.php" class="btn">subscribe now</a>
        </div>

    </div>

</section>











<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
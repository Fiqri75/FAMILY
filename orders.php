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
   <title>Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Your orders</h3>
    <p> <a href="home.php">Home</a> / Order </p>
</section>

<section class="placed-orders">

    <h1 class="title">placed orders</h1>

    <div class="box-container">

    <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
    ?>
    <div class="box">
        <div style="display: flex;">
            <div style="flex: 1;">
                <p> Placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                <p> Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                <p> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                <p> Your orders : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                <p> Total price : <span>Rp <?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                <p> Payment status : <span style="color:<?php if(strtolower($fetch_orders['payment_status']) == 'pending'){echo 'tomato'; }else{echo 'green';}?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>
            </div>
            <?php if($fetch_orders['type'] == 'konsultasi' && strtolower($fetch_orders['payment_status']) == 'completed'){ ?>
            <div style="display: flex; cursor: pointer;">
                <i class="fa-regular fa-comment-dots" style="font-size: 50px; margin-top:auto"></i>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php
        }
    }else{
        echo '<p class="empty">no orders placed yet!</p>';
    }
    ?>
    </div>

</section>







<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
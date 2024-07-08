<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   $expiredAt = null;
   $selectOrder = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id' LIMIT 1") or die('query failed');
   if(mysqli_num_rows($selectOrder) > 0){
      while($fetchOrder = mysqli_fetch_assoc($selectOrder)){
         $expiredDay = $fetchOrder['expired_day'];
         $expiredAt = date('Y-m-d H:i:s', strtotime('+'.$expiredDay.' days'));
      }
   }
   
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment', expired_at = '$expiredAt' WHERE id = '$order_id'") or die('query failed');
   $message[] = 'Payment status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

      <?php
      
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> User ID : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Placed on : <span><?php echo date( 'd-M-Y', strtotime( $fetch_orders['placed_on'] )); ?></span> </p>
         <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Total products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Total price : <span>Rp. <?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <?php if(strtolower($fetch_orders['payment_status']) != 'pending' && $fetch_orders['payment_status'] != ''){?>
            <p> Status : <span class="<?=strtolower($fetch_orders['payment_status'])?>-label"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         <?php }?>
         
         <!-- <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="Pending">Pending</option>
               <option value="Completed">Completed</option>
            </select>
            <input type="submit" name="update_order" value="update" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">delete</a>
         </form> -->
         <?php if (strtolower($fetch_orders['payment_status']) == 'pending') {?>
            <div class="wrapper-button-order">
               <form action="" method="post">
                  <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                  <input type="hidden" name="update_payment" value="Completed">
                  <input type="submit" name="update_order" value="COMPLETED" class="order-btn-action completed-btn">
               </form>
               <form action="" method="post">
                  <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                  <input type="hidden" name="update_payment" value="Cancel">
                  <input type="submit" name="update_order" value="CANCEL" class="order-btn-action cancel-btn">
               </form>
            </div>
         <?php }  ?>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No orders placed yet!</p>';
      }
      ?>
   </div>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>
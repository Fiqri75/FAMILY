<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

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

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
               $total_pendings += $fetch_pendings['total_price'];
            };
         ?>
         <h3>Rp<?php echo number_format($total_pendings, 0, ',', '.'); ?></h3>
         <p>Total Pendings</p>
      </div>

      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            while($fetch_completes = mysqli_fetch_assoc($select_completes)){
               $total_completes += $fetch_completes['total_price'];
            };
         ?>
         <h3 style="font-size: <?= strlen($total_completes) <7 ? '45px' : 47 -strlen($total_completes).'px' ?>">Rp<?php echo number_format($total_completes, 0, ',', '.'); ?></h3>
         <p>Completed Payments</p>
      </div>

      <div class="box">
         <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Orders Placed</p>
      </div>

      <div class="box">
         <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <h3><?php echo $number_of_products; ?></h3>
         <p>Products Added</p>
      </div>

      <div class="box">
         <?php
            // $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            // $number_of_users = mysqli_num_rows($select_users);
            $number_of_users_premium = 0;
            $selectPremium = mysqli_query($conn, "
               SELECT COUNT(*) as total, o.user_id FROM `orders` o 
               WHERE CURRENT_TIMESTAMP <= o.expired_at AND o.payment_status = 'completed'
               GROUP BY o.user_id
            ") or die('query failed');
            if(mysqli_num_rows($selectPremium) > 0){
               while($fetchNonPremium = mysqli_fetch_assoc($selectPremium)){
                  $number_of_users_premium = $fetchNonPremium['total'];
               }
            }
         ?>
         <h3><?php echo $number_of_users_premium; ?></h3>
         <p>Normal Users (Premium)</p>
      </div>
      <div class="box">
      <?php
            // $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            // $number_of_users = mysqli_num_rows($select_users);
            $number_of_users_non_premium = 0;
            $selectTotalUser = mysqli_query($conn, "
               SELECT COUNT(*) as total FROM `users` WHERE user_type = 'user'
            ") or die('query failed');
            if(mysqli_num_rows($selectTotalUser) > 0){
               while($fetchTotalUser = mysqli_fetch_assoc($selectTotalUser)){
                  $number_of_users_non_premium = $fetchTotalUser['total'] - $number_of_users_premium;
               }
            }
         ?>
         <h3><?php echo $number_of_users_non_premium; ?></h3>
         <p>Normal Users (Non Premium)</p>
      </div>

      <div class="box">
         <?php
            $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admin = mysqli_num_rows($select_admin);
         ?>
         <h3><?php echo $number_of_admin; ?></h3>
         <p>Admin Users</p>
      </div>

      <div class="box">
         <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
         ?>
         <h3><?php echo $number_of_account; ?></h3>
         <p>Total Accounts</p>
      </div>

      <div class="box">
         <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>New Messages</p>
      </div>

   </div>

</section>

<h1 class="title">Graphic</h1>


<div class="container-admin">
   <div class="row-admin">
      <div class="col-6-admin">
         <div class="card-admin-chart">
            <h1 class="title" style="text-align: center; font-size: 16px;">Grafik Total User yang Mendaftar di Tahun 2024</h1>
            <div  style="border: var(--border);"></>
               <canvas id="chartUser"></canvas>
            </div>
         </div>
      </div>
      
      <div class="col-6-admin">
         <div class="card-admin-chart">
            <h1 class="title" style="text-align: center; font-size: 16px;">Grafik Total Pembayaran Sudah Lunas di Tahun 2024</h1>
            <div  style="border: var(--border);"></>
               <canvas id="chartCompletedPayment"></canvas>
            </div>
         </div>
      </div>
      <div class="col-6-admin">
         <div class="card-admin-chart">
            <h1 class="title" style="text-align: center; font-size: 16px;">Grafik Total User Premium dan Non Premium</h1>
            <div style="border: var(--border);">
               <canvas id="chartUserPremiumOrNon"></canvas>
            </div>
         </div>
      </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   const baseURL = '<?=$baseUrl?>';
</script>


<script src="js/admin_script.js"></script>
</body>
</html>

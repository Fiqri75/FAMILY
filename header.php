<?php
// Pastikan untuk mengimpor konfigurasi database
@include 'config.php';

session_start();

// Memeriksa apakah pengguna sudah masuk
if (!isset($_SESSION['user_id'])) {
    $user_id = null;
} else {
    $user_id = $_SESSION['user_id'];
}

if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<link rel="stylesheet" href="css/style.css">

<header class="header">

    <div class="flex">

        <a href="home.php" class="logo">FAMILY</a>

        <nav class="navbar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="#">Pages +</a>
                    <ul>
                        <li><a href="seminar.php">Seminar</a></li>
                        <li><a href="shop.php">Subscription</a></li>
                        <li><a href="video.php">Playlist</a></li>
                        <li><a href="konsultasi.php">Consulting</a></li>

                    </ul>
                </li>
                <li><a href="orders.php">Orders</a></li>
                
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            
            <?php
            if ($user_id) {
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
            <?php
            } else {
                echo '<a href="login.php"><i class="fas fa-shopping-cart"></i><span>(0)</span></a>';
            }
            ?>
            <?php
                 $dayDiff = 0;
                 $selectOrder = mysqli_query($conn, "SELECT DATEDIFF(expired_at, NOW()) AS days_difference FROM `orders` WHERE user_id = '$user_id' AND CURRENT_TIMESTAMP <= expired_at AND payment_status = 'completed'") or die('query failed');
                 if(mysqli_num_rows($selectOrder) > 0){
                    while($fetchOrder = mysqli_fetch_assoc($selectOrder)){
                        if ($fetchOrder['days_difference'] > 0) {
                            $dayDiff += $fetchOrder['days_difference'];
                        }
                    }
                 }
                 $isPremium = $dayDiff > 0 ? true : false;
            ?>
            <?php
            if ($isPremium) {
            ?>
                <div id="premium" class="fa-solid fa-crown" style="color: orange;"><span style="padding-left:10px;"><?=$dayDiff?> Hari</span></div>
            <?php } ?>
        </div>
        

        <div class="account-box">
            <?php if ($user_id): ?>
                <p>Username: <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>Email: <span><?php echo $_SESSION['user_email']; ?></span></p>
                <a href="logout.php" class="delete-btn">Logout</a>
            <?php else: ?>
                <p><a href="login.php">Login</a> or <a href="register.php">Register</a></p>
            <?php endif; ?>
        </div>

    </div>

</header>

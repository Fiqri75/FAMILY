<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};
try {

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $placed_on = date('Y-m-d H:i:s');

    $cart_total = 0;
    $cart_products[] = '';
    $expired_day = 0;
    $type =null;

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
            $expired_day += $cart_item['expired_day'];
            $type = $cart_item['type'];
        }
    }

    $total_products = implode(' ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method'  AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'Your cart is empty!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'Order placed already!';
    }else{
        if (is_null($type)) {
            mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, total_products, total_price, placed_on, address, expired_day) VALUES('$user_id', '$name', '$number', '$email', '$method', '$total_products', '$cart_total', '$placed_on', '', '$expired_day')") or die('query failed');
        } else {
            mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, total_products, total_price, placed_on, address, expired_day, type) VALUES('$user_id', '$name', '$number', '$email', '$method', '$total_products', '$cart_total', '$placed_on', '', '$expired_day', '$type')") or die('query failed');
        }
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'Order placed successfully!';
    }
}
} catch (\Throwable $th) {
    die($th->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>checkout order</h3>
    <p> <a href="home.php">Home</a> / Checkout </p>
</section>

<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo 'Rp'.$fetch_cart['price'].',-'.' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">Your cart is empty</p>';
        }
    ?>
    <div class="grand-total">Grand Total : <span>Rp<?php echo $grand_total; ?>,-</span></div>
</section>

<section class="checkout">

    <form action="" method="POST">

        <h3>your order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Your name :</span>
                <input type="text" name="name" value="<?=isset($_SESSION['user_name']) ? $_SESSION['user_name'] : ''?>" placeholder="Enter your name">
            </div>
            <div class="inputBox">
                <span>Your number phone :</span>
                <input type="number" name="number" min="0" placeholder="Enter your number">
            </div>
            <div class="inputBox">
                <span>Your email :</span>
                <input type="email" name="email" value="<?=isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''?>" placeholder="Enter your email">
            </div>
            <div class="inputBox">
                <span>Payment method :</span>
                <select name="method">
                    <option value="BCA">BCA</option>
                    <option value="MANDIRI">MANDIRI</option>
                </select>
            </div>
        </div>

        <input type="submit" name="order" value="order now" class="btn">

    </form>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
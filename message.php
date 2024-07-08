<?php

@include 'config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if(isset($_POST['add_to_cart'])){
   if(isset($_POST['product_id'])) {
      $product_id = $_POST['product_id'];
      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_image = $_POST['product_image'];
   }  elseif(isset($_POST['konsultasi_id'])) {
      $product_id = $_POST['konsultasi_id'];
      $product_name = $_POST['konsultasi_name'];
      $product_price = $_POST['konsultasi_price'];
      $product_image = $_POST['konsultasi_image'];
   }

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'Already added to cart';
   }else{

       $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

       if(mysqli_num_rows($check_wishlist_numbers) > 0){
           mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
       }

       mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
       $message[] = 'Product added to cart';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- Chat Button and Window CSS -->
   <style>
      #chat-button {
         position: fixed;
         bottom: 25px;
         right: 20px;
         background-color: #5C8374;
         color: white;
         border-radius: 50%;
         width: 50px;
         height: 50px;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 24px;
         cursor: pointer;
         z-index: 1000;
      }

      #chat-window {
         position: fixed;
         bottom: 0;
         right: 0;
         width: 25%;
         height: 60%;
         background-color: white;
         border: 1px solid #092635;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
         display: none;
         flex-direction: column;
         z-index: 1000;
      }

      #chat-header {
         background-color: #092635;
         color: white;
         padding: 10px;
         display: flex;
         justify-content: space-between;
         align-items: center;
         font-size: 18px;
      }

      #chat-header #close-chat {
         cursor: pointer;
         font-size: 32px;
      }

      #chat-body {
         padding: 14px;
         overflow-y: auto;
         flex-grow: 1;
         font-size: 18px;
      }

      #chat-iframe {
         width: 100%;
         height: 100%;
         border: none;
      }
   </style>

</head>
<body>
   
<?php @include 'chatbot_header.php'; ?>

<!-- Chat Button and Window -->
<div id="chat-button">
   <i class="fas fa-comments"></i>
</div>

<div id="chat-window">
   <div id="chat-header">
      <span>Chat with our Chatbot</span>
      <span id="close-chat">&times;</span>
   </div>
   <div id="chat-body">
      <p>Hello! How can we help you?</p>
      <!-- You can add a chat form or iframe for chat service here -->
      <iframe id="chat-iframe" src="index.php"></iframe>
   </div>
</div>

<script>
   document.getElementById('chat-button').addEventListener('click', function() {
   document.getElementById('chat-window').style.display = 'flex';
   });

   document.getElementById('close-chat').addEventListener('click', function() {
   document.getElementById('chat-window').style.display = 'none';
   });
</script>
<script src="js/script.js"></script>

</body>
</html>

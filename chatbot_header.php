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
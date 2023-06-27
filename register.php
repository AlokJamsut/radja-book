<?php

include 'config.php';
include 'lang.php';

$email = '';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query gagal');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'User sudah ada!';
   }else{
      if($pass != $cpass){
         $message[] = 'Konfirmasi password tidak sama!';
      }else{
         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message[] = $lang['invalid_email'];
         } else {
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query gagal');
            $message[] = 'register berhasil!';
            header('location=login.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Daftar</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
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

<div class="form-container">
   <form action="" method="post">
      <h3>Daftar Sekarang</h3>
      <input type="text" name="name" placeholder="Masukkan nama" required class="box">
      <input type="email" name="email" placeholder="Masukkan email" required class="box">
      <input type="password" name="password" placeholder="Masukkan password" required class="box">
      <input type="password" name="cpassword" placeholder="Konfirmasi password" required class="box">
      <select name="user_type" class="box">
         <option value="user">User</option>
      </select>
      <input type="submit" name="submit" value="Daftar Sekarang" class="btn">
      <p>Sudah punya akun? <a href="login.php">Masuk sekarang</a></p>
   </form>
</div>

</body>
</html>

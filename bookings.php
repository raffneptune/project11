<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   setcookie('user_id', create_unique_id(), time() + 60*60*24*30, '/');
   header('location:index.php');
}

if(isset($_POST['cancel'])){

   $booking_id = $_POST['booking_id'];
   $booking_id = filter_var($booking_id, FILTER_SANITIZE_STRING);

   $verify_booking = $conn->prepare("SELECT * FROM `bookings` WHERE booking_id = ?");
   $verify_booking->execute([$booking_id]);

   if($verify_booking->rowCount() > 0){
      $delete_booking = $conn->prepare("DELETE FROM `bookings` WHERE booking_id = ?");
      $delete_booking->execute([$booking_id]);
      $success_msg[] = 'booking cancelled successfully!';
   }else{
      $warning_msg[] = 'booking cancelled already!';
   }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>bookings</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <link rel="shortcut icon" href="images/raffneptune.jpg" type="image/x-icon" />

</head>
<body>

<!-- header section starts  -->

<section class="header">

   <div class="flex">
      <a href="#home" class="logo">Hotels And Resorts</a>
      <a href="index.php#availability" class="btn">check availability</a>
      <div id="menu-btn" class="fas fa-bars"></div>
   </div>

   <nav class="navbar">
      <a href="index.php#home">home</a>
      <a href="index.php#about">about</a>
      <a href="index.php#reservation">reservation</a>
      <a href="index.php#gallery">gallery</a>
      <a href="index.php#contact">contact</a>
      <a href="index.php#reviews">reviews</a>
      <a href="bookings.php">my bookings</a>
   </nav>

</section>

<!-- header section ends -->

<!-- booking section starts  -->

<section class="bookings">

   <h1 class="heading">my bookings</h1>

   <div class="box-container">

   <?php
      $select_bookings = $conn->prepare("SELECT * FROM `bookings` WHERE user_id = ?");
      $select_bookings->execute([$user_id]);
      if($select_bookings->rowCount() > 0){
         while($fetch_booking = $select_bookings->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>name : <span><?= $fetch_booking['name']; ?></span></p>
      <p>email : <span><?= $fetch_booking['email']; ?></span></p>
      <p>number : <span><?= $fetch_booking['number']; ?></span></p>
      <p>check in : <span><?= $fetch_booking['check_in']; ?></span></p>
      <p>check out : <span><?= $fetch_booking['check_out']; ?></span></p>
      <p>rooms : <span><?= $fetch_booking['rooms']; ?></span></p>
      <p>adults : <span><?= $fetch_booking['adults']; ?></span></p>
      <p>childs : <span><?= $fetch_booking['childs']; ?></span></p>
      <p>booking id : <span><?= $fetch_booking['booking_id']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="booking_id" value="<?= $fetch_booking['booking_id']; ?>">
         <input type="submit" value="cancel booking" name="cancel" class="btn" onclick="return confirm('cancel this booking?');">
      </form>
   </div>
   <?php
    }
   }else{
   ?>   
   <div class="box" style="text-align: center;">
      <p style="padding-bottom: .5rem; text-transform:capitalize;">no bookings found!</p>
      <a href="index.php#reservation" class="btn">book new</a>
   </div>
   <?php
   }
   ?>
   </div>

</section>

<!-- booking section ends -->
























<!-- footer section starts  -->

<section class="footer">

   <div class="box-container">

      <div class="box">
         <a href="https://wa.me/6289635824169"><i class="fas fa-phone"></i> +62 896-3582-4169</a>
         <a href="https://wa.me/6282112824744"><i class="fas fa-phone"></i> +62 821-1282-4744</a>
         <a href="mailto:raffisaputra2410@gmail.com"><i class="fas fa-envelope"></i> raffisaputra2410@gmail.com</a>
         <a href="mailto:kevinsebastianshmbng@gmail.com"><i class="fas fa-envelope"></i> kevinsebastianshmbng@gmail.com</a>
         <a href="https://maps.app.goo.gl/qs2A4ksYj1ZxtQ2D7"><i class="fas fa-map-marker-alt"></i> JKT48 Theater</a>
      </div>

      <div class="box">
         <a href="index.php#home">home</a>
         <a href="index.php#about">about</a>
         <a href="bookings.php">my bookings</a>
         <a href="index.php#reservation">reservation</a>
         <a href="index.php#gallery">gallery</a>
         <a href="index.php#contact">contact</a>
         <a href="index.php#reviews">reviews</a>
      </div>

      <div class="box">
         <a href="#">facebook <i class="fab fa-facebook-f"></i></a>
         <a href="#">twitter <i class="fab fa-twitter"></i></a>
         <a href="https://www.instagram.com/raffneptune">instagram <i class="fab fa-instagram"></i></a>
         <a href="#">linkedin <i class="fab fa-linkedin"></i></a>
         <a href="#">youtube <i class="fab fa-youtube"></i></a>
      </div>

   </div>

   <div class="credit">&copy; copyright @ 2025 by raffneptune | all rights reseved!</div>

</section>

<!-- footer section ends -->

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>
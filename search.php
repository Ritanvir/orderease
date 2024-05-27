<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
   /* Custom styles for live search results */
   #livesearch {
      position: absolute;
      background-color: white;
      border: 1px solid #A5ACB2;
      width: 100%;
      max-width: 400px;
      z-index: 1000;
   }

   #livesearch .box {
      display: flex;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-decoration: none;
      color: inherit;
   }

   #livesearch .box img {
      width: 200px;
      height: 200px;
      object-fit: cover;
      margin-right: 10px;
   }

   #livesearch .box .name {
      font-size: 16px;
      font-weight: bold;
      margin-right: auto;
   }

   #livesearch .box .price {
      font-size: 14px;
      color: #888;
   }

   #livesearch .box:hover {
      background-color: #f1f1f1;
   }

   .empty {
      padding: 10px;
      color: #888;
      text-align: center;
   }
   </style>

   <script>
   function showResult(str) {
      if (str.length == 0) {
         document.getElementById("livesearch").innerHTML = "";
         document.getElementById("livesearch").style.border = "0px";
         return;
      }
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
            document.getElementById("livesearch").innerHTML = this.responseText;
            document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
         }
      }
      xmlhttp.open("GET", "livesearch.php?q=" + encodeURIComponent(str), true);
      xmlhttp.send();
   }
   </script>

</head>
<body>

<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- search form section starts  -->
<section class="search-form">
   <form method="post" action="">
      <input type="text" name="search_box" placeholder="search here..." class="box" onkeyup="showResult(this.value)">
   </form>
   <div id="livesearch"></div>
</section>
<!-- search form section ends -->

<section class="products" style="min-height: 100vh; padding-top:0;">
<div class="box-container">
   <!-- Initial load of products if needed -->
</div>
</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>






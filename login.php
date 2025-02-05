<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_COOKIE['user_id']) && isset($_COOKIE['password']))
{ 
   //global $email,$password;
   $email=$_COOKIE['user_id'];
   $password=$_COOKIE['password'];
}
else{
  $email=$password="";
}
if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];

            // Check if 'Remember me' is checked
            if(isset($_POST['remember'])) {
               // Set a cookie for 2 hours
               setcookie('user_id', $row['email'], time() + 60*60); // 1 hour
               setcookie('password', $_POST['pass'], time() + 60*60); // 1 hour
            }

            else{
               setcookie('user_id', $row['email'], time()-10);
               setcookie('password', $_POST['pass'], time()-10);
            }

      header('location:home.php?user_id='.$row['id']);
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="icon" type="image/x-icon" href="https://assets.epicurious.com/photos/5c745a108918ee7ab68daf79/16:9/w_3743,h_2105,c_limit/Smashburger-recipe-120219.jpg">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<script>
   $(document).ready(function() {
      $('form').submit(function(event) {
         event.preventDefault();
         $.ajax({
            url: 'login.php',
            type: 'POST',
            data: $('form').serialize(),
            success: function(response) {
               if(response == "success") {
                  location.reload();
               } else {
                  alert(response);
               }
            }
         });
      });
   });
</script>

<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" value="<?php echo $email; ?>">
      <input type="password" name="pass" required placeholder="enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" value="<?php echo $password; ?>">
      <br><br>
        <!--- for cookies------------->
      <input type="checkbox" name="remember" id="remember" style="">
       <label for="remember" style="font-size: 16px;color:gray">Remember me</label><br><br>


      <input type="submit" value="login now" name="submit" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</section>











<?php include 'components/footer.php'; ?>






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
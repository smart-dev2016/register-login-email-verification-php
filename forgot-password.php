<?php
session_start();
include 'db_conn.php';
include 'functions.php';

$msg = "";

if (isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: home.php");
  die();
}

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $code = md5(rand());

  if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
    $query = mysqli_query($conn, "UPDATE users SET code='{$code}' WHERE email='{$email}'");

    if ($query) {
      if (send_email($email, $code, 'reset_pwd')) {
        $msg = "<div class='alert alert-info'>We've sent a password reset link to your email address.</div>";
      } else {
        $msg = "<div class='alert alert-danger'>Failed to send password reset email.</div>";
      }
    }
  } else {
    $msg = "<div class='alert alert-danger'>$email - This email address was not found.</div>";
  }
}
?>

<?php include 'inc/header.php' ?>
<section class="w3l-mockup-form">
  <div class="container">
    <div class="workinghny-form-grid">
      <div class="main-mockup">
        
        <div class="w3l_form align-self">
          <div class="left_grid_info">
            <img src="assets/images/image3.svg" alt="">
          </div>
        </div>
        <div class="content-wthree">
          <h2>Forgot Password</h2>
          <p>Plese fill these fields </p>
          <?php echo $msg; ?>
          <form action="" method="post">
            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
            <button name="submit" class="btn" type="submit">Send Reset Link</button>
          </form>
          <div class="social-icons">
            <p>Back to! <a href="index.php">Login</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'inc/footer.php' ?>
<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: home.php");
  die();
}

include 'db_conn.php';
include 'functions.php';

if (isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: home.php");
  die();
}

$msg = "";

if (isset($_GET['verification'])) {
  $verificationCode = $_GET['verification'];

  if (isEmailVerified($conn, $verificationCode)) {
    if (updateVerificationCode($conn, $verificationCode)) {
      $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
    }
  } else {
    header("Location: index.php");
  }
}

if (isset($_POST['submit'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $user = loginUser($conn, $email, $password);

  if ($user) {
    if (empty($user['code'])) {
      $_SESSION['SESSION_EMAIL'] = $email;
      header("Location: home.php");
    } else {
      $msg = "<div class='alert alert-info'>First verify your account and try again.</div>";
    }
  } else {
    $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
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
            <img src="assets/images/logo.png" alt="">
          </div>
        </div>
        <div class="content-wthree">
          <h2>Login Now</h2>
          <p>Plese fill these fields.. </p>
          <?php echo $msg; ?>
          <form action="" method="post">
            <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
            <input type="password" class="password" name="password" placeholder="Enter Your Password"
              style="margin-bottom: 2px;" required>
            <p><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot
                Password?</a>
            </p>
            <button name="submit" name="submit" class="btn" type="submit">Login</button>
          </form>
          <div class="social-icons">
            <p>Create Account! <a href="register.php">Register</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'inc/footer.php' ?>
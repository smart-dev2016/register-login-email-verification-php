<!-- register.php -->
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
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
  $code = md5(rand());

  if (isEmailExists($conn, $email)) {
    $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
  } else {
    if ($password === $confirm_password) {
      if (registerUser($conn, $name, $email, $password, $code)) {
        if (send_email($email, $code, 'verify')) {
          $msg = "<div class='alert alert-info'>We've sent a verification link to your email address.</div>";
        } else {
          $msg = "<div class='alert alert-danger'>Failed to send verification email.</div>";
        }
      } else {
        $msg = "<div class='alert alert-danger'>Something went wrong during registration.</div>";
      }
    } else {
      $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
    }
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
          <h2>Register Now</h2>
          <p>Plese fill these fields </p>
          <?php echo $msg; ?>
          <form action="" method="post">
            <input type="text" class="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) {
              echo $name;
            } ?>" required>
            <input type="email" class="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) {
              echo $email;
            } ?>" required>
            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
            <input type="password" class="confirm-password" name="confirm-password"
              placeholder="Enter Your Confirm Password" required>
            <button name="submit" class="btn" type="submit">Register</button>
          </form>
          <div class="social-icons">
            <p>Have an account! <a href="index.php">Login</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include 'inc/footer.php' ?>
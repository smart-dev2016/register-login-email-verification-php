<?php

$msg = "";

include 'db_conn.php';

if (isset($_GET['reset'])) {
  if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE code='{$_GET['reset']}'")) > 0) {
    if (isset($_POST['submit'])) {
      $password = mysqli_real_escape_string($conn, md5($_POST['password']));
      $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

      if ($password === $confirm_password) {
        $query = mysqli_query($conn, "UPDATE users SET password='{$password}', code='' WHERE code='{$_GET['reset']}'");

        if ($query) {
          header("Location: index.php");
        }
      } else {
        $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
      }
    }
  } else {
    $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
  }
} else {
  header("Location: forgot-password.php");
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
          <h2>Change Password</h2>
          <p>Plese fill these fields </p>
          <?php echo $msg; ?>
          <form action="" method="post">
            <input type="password" class="password" name="password" placeholder="Enter Your Password" required>
            <input type="password" class="confirm-password" name="confirm-password"
              placeholder="Enter Your Confirm Password" required>
            <button name="submit" class="btn" type="submit">Change Password</button>
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
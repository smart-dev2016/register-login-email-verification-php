<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function isEmailVerified($conn, $verificationCode)
{
  $query = "SELECT * FROM users WHERE code='$verificationCode'";
  return mysqli_num_rows(mysqli_query($conn, $query)) > 0;
}

function updateVerificationCode($conn, $verificationCode)
{
  $query = "UPDATE users SET code='' WHERE code='$verificationCode'";
  return mysqli_query($conn, $query);
}

function loginUser($conn, $email, $password)
{
  $hashedPassword = md5($password);
  $query = "SELECT * FROM users WHERE email='$email' AND password='$hashedPassword'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    return $row;
  } else {
    return false;
  }
}
function isEmailExists($conn, $email)
{
  $query = "SELECT * FROM users WHERE email='{$email}'";
  return mysqli_num_rows(mysqli_query($conn, $query)) > 0;
}

function registerUser($conn, $name, $email, $password, $code)
{
  $hashedPassword = md5($password);
  $sql = "INSERT INTO users (name, email, password, code) VALUES ('{$name}', '{$email}', '{$hashedPassword}', '{$code}')";
  return mysqli_query($conn, $sql);
}

function send_email($email, $code, $for)
{
  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'golden.starr1997@gmail.com';
    $mail->Password = 'zlrn ooiv lyfo egxb';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('golden.starr1997@gmail.com');
    $mail->addAddress($email);

    $mail->isHTML(true);

    if ($for == 'reset_pwd') {
      $mail->Subject = 'Reset password verfiy';
      $mail->Body = 'Here is the verification link <b><a href="http://localhost/auth_test/change-password.php?reset='
        . $code . '">http://localhost/auth_test/change-password.php?reset='
        . $code . '</a></b>';
    } else {
      $mail->Subject = 'Register verfiy';
      $mail->Body = 'Here is the verification link <b><a href="http://localhost/auth_test/?verification='
        . $code . '">http://localhost/auth_test/?verification='
        . $code . '</a></b>';
    }

    $mail->send();

    return true;
  } catch (Exception $e) {
    return false;
  }
}
?>
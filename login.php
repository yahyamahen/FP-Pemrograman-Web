<?php
session_start();
require_once "function.php";

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
   $id = $_COOKIE['id'];
   $key = $_COOKIE['key'];

   $query = "SELECT npm FROM mahasiswa WHERE nama_mhs = '$id';";
   $result = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($result);

   if ($key === hash('sha256', $row['npm'])) {
      $_SESSION['login'] = true;
      $_SESSION['npm'] = $row['npm'];
   }
}

if (isset($_SESSION['login'])) {
   header('Location: home');
   exit;
}

if (isset($_POST['login'])) {
   $npm = $_POST['npm'];
   $password = $_POST['password'];

   $result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE npm = '$npm';");

   // cek username
   if (mysqli_num_rows($result) === 1) {
      //cek password
      $row = mysqli_fetch_assoc($result);

      echo "<br>" . $password;
      echo "<br>";
      var_dump($row);

      if (password_verify($password, $row['pass'])) {
         // set session
         $_SESSION['login'] = true;
         $_SESSION['npm'] = $row['npm'];

         if (isset($_POST['remember'])) {
            setcookie('id', $row['nama_mhs'], time() + 60);
            setcookie('key', hash('sha256', $row['npm']), time() + 60);
         }

         header("Location: home");
         exit;
      }
   }

   $error = true;
}
?>

<!doctype html>
<html lang="en">

<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="css/bootstrap.css">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> -->

   <title>Login</title>

</head>

<body class="login-body">
   <div class="row login-frame">
      <div class="col-md-5 d-flex flex-column justify-content-center">
         <div class="header-title mb-4 ml-4 align-self-center">
            <h1>SiPesan</h1>
            <h5>(Sistem Informasi Surat Pengantar Perusahaan)</h5>
         </div>
         <div class="form-login-body align-self-center">
            <h3>Masuk</h3>
            <form action="" method="POST" class="row g-1" id="form-login">
               <div class="form-group col-md-12">
                  <label for="npm">NPM</label>
                  <input class="form-control" type="text" id="npm" name="npm" placeholder="NPM">
               </div>

               <div class="form-group col-md-12">
                  <label for="pass">Password</label>
                  <input class="form-control" type="password" id="password" name="password" placeholder="*********">
               </div>

               <div class="col-12">
                  <div class="form-check text-center">
                     <input class="form-check-input" type="checkbox" id="remember" name="remember">
                     <label class="form-check-label" for="remember"> Remember Me</label>
                  </div>
               </div>

               <div class=" form-group col-md-12 mt-2">
                  <button type="submit" name="login" id="login" class="form-control btn btn-primary"> MASUK </button>
               </div>
               <?php if (isset($error)) : ?>
                  <div class="form-group col-md-12">
                     <p class="text-center" style="color: red; font-style: italic;">NPM / password salah</p>
                  </div>
               <?php endif; ?>
            </form>
            <div class="text-center mb-2 col-md-12"><a href="register">Register Akun</a></div>
            <div class="text-center col-md-12">Lupa Password? <a href="#">Hubungi Admin</a></div>
         </div>
      </div>

      <div class="col-md-7">
         <div class="hero">
            <!-- <img src="images/login-bg.png" alt="bg"> -->
         </div>
      </div>
   </div>

   <script src="js/jquery-3.5.1.js"></script>
   <script src="js/jquery-3.5.1.min.js"></script>
   <script src="js/bootstrap.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <!-- <script src="bootstrap.bundle.js"></script> -->
   <!-- <script src="bootstrap.bundle.min.js"></script> -->
   <script src="js/font-awesome.min.js"></script>

   <!-- Optional JavaScript; choose one of the two! -->

   <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->

   <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
   <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->

   <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
   <!-- <script src="https//code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
   <!-- <script src="https//cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
   <!-- <script src="https//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->

   <script src="js/script.js"></script>

</body>

</html>
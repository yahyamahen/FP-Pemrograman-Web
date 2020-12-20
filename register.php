<?php
require_once "function.php";
function mahasiswaCreated()
{
   global $conn;

   if (isset($_POST["regist"])) {
      if (registration($_POST) == 1) {
         echo
            '<div class="form-group col-md-12">
               <p class="text-center" style="color: black; font-style: italic;">Data Mahasiswa Ditambahkan</p>
            </div>"';
         echo
            "<script>
				alert('Data Mahasiswa Ditambahkan');
         </script>";
         header('Location  : login.php');
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "'</script>;";
      }
   }
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

   <title>SiPesan</title>

</head>

<body class="register-body">
   <div class="row register-frame">
      <div class="col-md-6">
         <div class="hero">
            <div class="header-title">
               <h1> SiPesan</h1>
               <h5>(Sistem Informasi Surat Pengantar Perusahaan)</h5>
            </div>
         </div>
      </div>

      <div class="col-md-6 d-flex flex-column justify-content-center">
         <div class="form-register-body align-self-center mr-5 mt-2">
            <h3>Daftar</h3>
            <form class="row g-2" action="" method="post">
               <div class="col-md-12">
                  <label for="npm" class="form-label">NPM</label>
                  <input type="text" class="form-control" id="npm" name="npm" placeholder="NPM">
               </div>
               <div class="col-12">
                  <label for="nama_mhs" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="nama_mhs" name="nama_mhs" placeholder="Nama Lengkap Mahasiswa">
               </div>
               <div class="col-md-6">
                  <label for="jurusan" class="form-label">Jurusan</label>
                  <select id="jurusan" name="jurusan" class="form-control">
                     <option selected value="Teknik Infromatika">Teknik Informatika</option>
                     <option value="Sistem Informasi">Sistem Informasi</option>
                  </select>
               </div>
               <div class="col-md-6">
                  <label for="semester" class="form-label">Semester</label>
                  <input type="number" class="form-control" id="semester" name="semester" placeholder="Semester">
               </div>
               <div class="col-12">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="mahasiswa@mail.com">
               </div>
               <div class="col-md-12">
                  <label for="pass" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="********">
               </div>
               <div class="col-md-12">
                  <label for="pass2" class="form-label">Konfirmasi Password</label>
                  <input type="password" class="form-control" id="password2" name="password2" placeholder="********">
               </div>
               <div class="col-12">
                  <button type="submit" class="mt-4 form-control btn btn-primary" name="regist">DAFTAR</button>
                  <?php mahasiswaCreated(); ?>
               </div>
               <div class="col-12">
                  <li class="list-group text-center mt-2"><a href="login.php">LOGIN</a></li>
                  <p class="text-center">NPM sudah digunakan? <a href="#">Hubungi Admin</a></p>
               </div>
            </form>
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
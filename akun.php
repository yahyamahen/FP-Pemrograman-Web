<?php
session_start();
require "function.php";
require "model.php";

function mahasiswaUpdated()
{
   global $conn;

   if (isset($_POST["update"])) {
      if (update($_POST) == 1) {
         // echo
         //    '<div class="form-group col-md-12">
         //       <p class="text-center" style="color: black; font-style: italic;">Data Mahasiswa Terupdate</p>
         //    </div>"';
         echo
            "<script>
            alert('Data Mahasiswa Terupdate');
            document.location.href= 'akun';
         </script>";
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

<body>

   <div class="row">
      <?php require_once "sidebar.php" ?>

      <div class="col-md-10">
         <div class="row akun-body">
            <div class="col-md-12">
               <div class="biodata-title mt-5">
                  <h3 class=" d-inline ml-5">BIODATA MAHASISWA</h3>
                  <input type="button" class="ml-3 mt-n2 btn btn-outline-info" data-toggle="modal" data-target="#form-update" value="Sunting">
               </div>
               <div class="profile-details mt-4 ml-5">
                  <?php foreach ($mahasiswa as $mhs) : ?>
                     <img class="rounded-circle d-inline-block mb-3" src=" images/<?= $mhs['npm']; ?>/<?= $mhs['foto_profil']; ?>" alt="profile">
                     <table cellspacing="0px" cellpadding="1px" border="0px" class="ml-1">
                        <tr>
                           <td class="pr-5">Nama Mahasiswa</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $mhs['npm']; ?></td>
                        </tr>

                        <tr>
                           <td class="pr-5">NPM</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $mhs['nama_mhs'] ?></td>
                        </tr>
                        <tr>
                           <td class="pr-5">Jurusan</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $mhs['jurusan'] ?></td>
                        </tr>
                        <tr>
                           <td class="pr-5">Semester</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $mhs['semester'] ?></td>
                        </tr>
                        <tr>
                           <td class="pr-5">Email</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $mhs['email'] ?></td>
                        </tr>
                        <tr>
                           <td colspan="3">
                              <p><a href="#" class="pt-2 d-block card-link">Ganti Password</a></p>
                           </td>
                        </tr>
                     </table>

                  <?php endforeach; ?>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="form-update" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="judulModal">UPDATE BIODATA</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="" class="row g-3" method="POST" enctype="multipart/form-data">
                  <div class="row biodata-body">
                     <?php foreach ($mahasiswa as $mhs) : ?>
                        <input type="hidden" name="foto_profil_lama" id="foto_profil_lama" value="<?= $mhs['foto_profil'] ?>">
                        <div class="col-md-12">
                           <label for="npm" class="form-label">NPM</label>
                           <input type="text" class="form-control" id="npm" name="npm" placeholder="NPM" value="<?= $mhs['npm']; ?>" disabled>
                        </div>
                        <div class="col-12">
                           <label for="nama_mhs" class="form-label">Nama Lengkap</label>
                           <input type="text" class="form-control" id="nama_mhs" name="nama_mhs" placeholder="Nama Mahasiswa" value="<?= $mhs['nama_mhs']; ?>">
                        </div>
                        <div class="col-md-9">
                           <label for="jurusan" class="form-label">Jurusan</label>
                           <select id="jurusan" name="jurusan" class="form-control">
                              <option value="Teknik Infromatika" selected>Teknik Informatika</option>
                              <option value="Sistem Informasi">Sistem Informasi</option>
                           </select>
                        </div>
                        <div class="col-md-3">
                           <label for="semester" class="form-label">Semester</label>
                           <input type="number" class="form-control" id="semester" name="semester" placeholder="Semester" value="<?= $mhs['semester']; ?>">
                        </div>
                        <div class=" col-12">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" id="email" name="email" placeholder="mahasiswa@mail.com" value="<?= $mhs['email']; ?>">
                        </div>
                        <div class=" col-12">
                           <label for="foto_profil" class="form-label">Foto Profil</label>
                        </div>
                        <div class="col-3 d-flex">
                           <img class="rounded-circle profile-photo" src="images/<?= $mhs['npm'] ?>/<?= $mhs['foto_profil'] ?>" alt="profile1">
                           <input type="file" class="" id="foto_profil" name="foto_profil">
                        </div>
                  </div>
               <?php endforeach; ?>
            </div>
            <div class="modal-footer mt-n2 d-flex">
               <button type="submit" name="update" id="update" class="btn btn-info modal-button w-25">UPDATE</button>
            </div>
            </form>
            <?php mahasiswaUpdated(); ?>
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
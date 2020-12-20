<?php
session_start();
require_once "function.php";


if (!isset($_SESSION["login"])) {
   header("Location: login.php");
   exit;
}

if (isset($_SESSION['login']) && isset($_SESSION['npm'])) {
   $npm = $_SESSION['npm'];
}

$mahasiswa = read("SELECT * FROM users WHERE npm = '$npm'");
// $surat = read("SELECT * FROM surat WHERE npm = '$npm'");
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
      <?php require "sidebar.php" ?>

      <div class="col-md-10">
         <div class="content">
            <h2 class="mt-1">SiPesan (Sistem Informasi Surat Pengantar Perusahaan)</h2>
            <div class="profile-details d-flex mt-4">
               <?php foreach ($mahasiswa as $mhs) : ?>
                  <img class="rounded-circle d-inline-block mb-3" src=" images/<?= $mhs['npm']; ?>/<?= $mhs['foto_profile']; ?>" alt="profile">
                  <table cellspacing="0px" cellpadding="1px" border="0px" class="ml-4">
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
                  </table>
               <?php endforeach; ?>
            </div>

            <div class="row mt-3">
               <div class="col-md-6">
                  <button type="button" class="btn btn-info tombolTambahData" data-toggle="modal" data-target="#formModal">Buat Surat</button>
               </div>
               <div class="col-lg-6">
                  <form action="#" method="post">
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari File Surat.." name="keyword" id="keyword" autocomplete="off">

                        <div class="input-group-append">
                           <button class="btn btn-outline-info" type="submit" id="tombolCari">Cari</button>
                        </div>

                     </div>
                  </form>
               </div>

               <table class="table mt-3">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>File Surat</th>
                        <th>Kegiatan</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <th>1</th>
                        <td>Surat Pengantar Magang PT ABC</td>
                        <td>
                           <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="#">Hapus</a>

                           <a class="badge badge-pill badge-success ml-1 tampilModalUbah" data-toggle="modal" data-target="#formModal" href="#" data-npm="#">Update</a>

                           <a class="badge badge-pill badge-primary ml-1" href="#">Detail</a>
                        </td>
                     </tr>
                     <tr>
                        <th>2</th>
                        <td>Surat Pengantar Magang PT DEF</td>
                        <td>
                           <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="#">Hapus</a>

                           <a class="badge badge-pill badge-success ml-1 tampilModalUbah" data-toggle="modal" data-target="#formModal" href="#" data-npm="#">Update</a>

                           <a class="badge badge-pill badge-primary ml-1" href="#">Detail</a>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="judulModal">Buat Surat</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="#" method="post" enctype="multipart/form-data">
                     <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                     </div>

                     <div class="form-group">
                        <label for="npm">NPM</label>
                        <input type="number" class="form-control" id="npm" name="npm">
                     </div>

                     <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                     </div>

                     <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <select class="form-control" id="jurusan" name="jurusan">
                           <option value="Teknik Informatika">Teknik Informatika</option>
                           <option value="Sistem Informasi">Sistem Informasi</option>
                           <option value="Teknik Mesin">Teknik Mesin</option>
                           <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                           <option value="Ekonomi Pembangunan">Ekonomi Pembangunan</option>
                        </select>
                     </div>

                     <div class="form-group mb-2">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control " id="jenis_kelamin" name="jenis_kelamin">
                           <option value="L">Laki Laki</option>
                           <option value="P">Perempuan</option>
                        </select>
                     </div>

                     <div class="fotoprofil mt-3 mb-3">
                        <div class="custom-file mb-3 mt-3 d-inline">
                           <input type="file" class="custom-file-input" id="validatedCustomFile" name="gambar" required>
                           <label class="custom-file-label" for="validatedCustomFile">Pilih foto profil</label>
                           <div class="invalid-feedback">Example invalid custom file feedback</div>
                        </div>
                     </div>

                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                  </form>
               </div>

            </div>
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
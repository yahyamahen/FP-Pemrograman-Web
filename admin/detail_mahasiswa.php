<?php
session_start();
require_once "function.php";
require_once "model.php";

if (isset($_GET['npm'])) {
   $npm = $_GET['npm'];
   $mahasiswa = read("SELECT * FROM mahasiswa WHERE npm = '$npm'");
}

function mahasiswaUpdated()
{
   global $conn;
   if (isset($_POST["update_mhs"])) {
      if (update($_POST) > 0) {
         echo
            "<script>
               alert('Data Mahasiswa Terupdate');
               document.location.href= 'detail_mahasiswa?npm=" . $_POST['npm'] . "';
            </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "');</script>;";
      }
   }
}

function passwordUpdated()
{
   global $conn;
   if (isset($_POST['update_password'])) {
      if (updatePassword($_POST) > 0) {
         echo
            "<script>
            alert('Password Baru Mahasiswa : " . $_POST['password_baru'] . "');
            document.location.href= 'detail_mahasiswa?npm=" . $_POST['npm_pass'] . "';
         </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "');</script>;";
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
   <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
   <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">

   <title>SiPesan (Admin)</title>
</head>

<body>
   <div class="row">
      <div class="col-md-2 sidebar-outer">
         <?php require_once "sidebar.php" ?>
      </div>

      <div class="col-md-10">
         <div class="row akun-body">
            <div class="col-md-12">
               <div class="biodata-title mt-5">
                  <h3 class=" d-inline ml-5">BIODATA MAHASISWA</h3>
                  <?php foreach ($mahasiswa as $data) : ?>
                     <input type="button" class="ml-3 mt-n2 btn btn-outline-info sunting-mhs-btn" data-toggle="modal" data-target="#form-update" value="Sunting" name="update_mhs" id="update_mhs" data-npm="<?= $data['npm'] ?>" data-nama_mhs="<?= $data['nama_mhs'] ?>" data-jurusan="<?= $data['jurusan'] ?>" data-semester="<?= $data['semester'] ?>" data-email="<?= $data['email'] ?>" data-foto_profil_lama="<?= $data['foto_profil'] ?>">
                  <?php endforeach; ?>
               </div>
               <div class="profile-details mt-4 ml-5">
                  <?php foreach ($mahasiswa as $data) : ?>
                     <?php if (trim($data['foto_profil'] == '')) : ?>
                        <div class="d-flex justify-content-center overflow-hidden align-self-center mb-4" style="width: 9em; height:9em; border-radius:400em;">
                           <img class="d-inline-block align-self-center" style="width:8em;" src="../images/guest_user.png" alt="guest">
                        </div>
                     <?php else : ?>
                        <div class="d-flex justify-content-center overflow-hidden align-self-center mb-4" style="width: 9em; height:9em; border-radius:400em;">
                           <img class="d-inline-block align-self-center" style="width:9em;" src="../images/<?= $data['npm'] ?>/<?= $data['foto_profil'] ?>" alt="profile">
                        </div>
                     <?php endif; ?>
                     <table cellspacing="0px" cellpadding="1px" border="0px" class="ml-1">
                        <tr>
                           <td class="pr-5">Nama Mahasiswa</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $data['npm']; ?></td>
                        </tr>

                        <tr>
                           <td class="pr-5">NPM</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $data['nama_mhs'] ?></td>
                        </tr>
                        <tr>
                           <td class="pr-5">Jurusan</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $data['jurusan'] ?></td>
                        </tr>
                        <tr>
                           <td class="pr-5">Semester</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $data['semester'] ?></td>
                        </tr>
                        <tr>
                           <td class="pr-5">Email</td>
                           <td align="center">:</td>
                           <td class="pl-2"><?= $data['email'] ?></td>
                        </tr>
                        <tr>
                           <td colspan="3">
                              <p><a data-toggle="modal" data-target="#form-update-password" href="detail_mahasiswa?npm=<?= $data['npm'] ?>" class="pt-2 d-block card-link">Ganti Password</a></p>
                           </td>
                        </tr>
                     </table>
                  <?php endforeach; ?>
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
                        <input type="hidden" name="foto_profil_lama" id="foto_profil_lama">
                        <input type="hidden" name="npm" id="npm">
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
                              <option value="Teknik Informatika">Teknik Informatika</option>
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
                           <div class="d-flex justify-content-center overflow-hidden align-self-center" style="width: 3em; height:3em; border-radius:400em;">
                              <img class="modal-photo align-self-center" style="width: 3em;" src="" alt="">
                           </div>
                           <input type="file" class="" id="foto_profil" name="foto_profil">
                        </div>
                     </div>
               </div>
               <div class="modal-footer mt-n2 d-flex">
                  <button type="submit" name="update" id="update" class="btn btn-info modal-button w-25">UPDATE</button>
               </div>
               </form>
               <?php mahasiswaUpdated(); ?>
            </div>
         </div>
      </div>

      <div class="modal fade" id="form-update-password" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title ml-5 pl-5" id="judulModal">UPDATE PASSWORD</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="" class="row g-3" method="POST">
                     <div class="row biodata-body">
                        <input type="hidden" name="npm_pass" id="npm_pass" value="<?= $data['npm'] ?>">
                        <div class="col-md-12">
                           <label for="npm" class="form-label">NPM</label>
                           <input type="text" class="form-control" id="npm_pass" name="npm_pass" placeholder="NPM" value="<?= $data['npm']; ?>" disabled>
                        </div>
                        <div class="col-12">
                           <label for="password_baru" class="form-label">Password Baru</label>
                           <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="********">
                        </div>
                     </div>
               </div>
               <div class="modal-footer mt-n2 d-flex">
                  <button type="submit" name="update_password" id="update_password" class="btn btn-info modal-button w-25">Update Password</button>
               </div>
               </form>
               <?php passwordUpdated(); ?>
            </div>
         </div>
      </div>


      <script src="../js/js/jquery-3.5.1.js"></script>
      <script src="../js/js/jquery-3.5.1.min.js"></script>
      <script src="../js/js/bootstrap.js"></script>
      <script src="../js/js/bootstrap.min.js"></script>
      <!-- <script src="../js/js/bootstrap.bundle.js"></script> -->
      <!-- <script src="../js/js/bootstrap.bundle.min.js"></script> -->
      <script src="../js/js/font-awesome.min.js"></script>
      <script src="js/script.js"></script>

      <script>
         $(function() {
            $('.sunting-mhs-btn').on('click', function() {
               $('#judulModal').html('Edit Bidoata Mahasiswa');
               $('#judulModal').addClass('ml-5 pl-5');
               $('.modal-footer button[type=submit]').addClass('btn btn-success');
               $('.modal-footer button[type=submit]').html('Update');
               $('.modal-footer button[type=submit]').attr('name', 'update_mhs');

               let npm = $(this).data('npm');
               let nama_mhs = $(this).data('nama_mhs');
               let jurusan = $(this).data('jurusan');
               let semester = $(this).data('semester');
               let email = $(this).data('email');
               let foto_profil = $(this).data('foto_profil_lama');

               $('.modal-body #npm').val(npm);
               $('.modal-body #nama_mhs').val(nama_mhs);
               $('.modal-body #jurusan').val(jurusan);
               $('.modal-body #semester').val(semester);
               $('.modal-body #email').val(email);
               $('.modal-body #foto_profil_lama').val(foto_profil);
               $('.modal-body .modal-photo').attr('src', '../images/' + npm + '/' + foto_profil);
               $('.modal-body .modal-photo').attr('alt', '../images/' + npm + '/' + foto_profil);
            });
         });
      </script>
</body>

</html>
<?php
session_start();
require_once "function.php";
require_once "model.php";

$jurusan = read("SELECT jurusan FROM mahasiswa GROUP BY jurusan;");
$mahasiswa = read("SELECT * FROM mahasiswa");

if (isset($_POST['search_btn'])) {
   $key = $_POST['keyword'];
   $mahasiswa = read("SELECT * FROM mahasiswa WHERE 
   (npm LIKE '%$key%' OR
   nama_mhs LIKE '%$key%' OR 
   jurusan LIKE '%$key%' OR
   semester LIKE '%$key%');");
}

if (isset($_GET['jurusan'])) {
   $jrs = $_GET['jurusan'];
   $mahasiswa_filter = read("SELECT * FROM mahasiswa WHERE jurusan = '$jrs';");
   if (isset($_POST['search_btn'])) {
      $key = $_POST['keyword'];
      $mahasiswa_filter = read("SELECT * FROM mahasiswa WHERE jurusan = '$jrs' && 
		(npm LIKE '%$key%' OR
		nama_mhs LIKE '%$key%' OR 
      semester LIKE '%$key%');");
   }
}

function mahasiswaUpdated()
{
   global $conn;

   if (isset($_POST["update_mhs"])) {
      if (update($_POST) == 1) {
         echo
            "<script>
               alert('Data Mahasiswa Terupdate');
               document.location.href= 'mahasiswa';
            </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "');</script>;";
      }
   }
}

if (isset($_GET["delete"])) {
   $npm = $_GET['delete'];
   if (delete_mhs($npm) > 0) {
      echo
         "<script>
            alert('Mahasiswa Berhasil Dihapus');
            document.location.href='mahasiswa';
         </script>";
   } else {
      echo
         "<script>
            alert('Surat Tidak Berhasil Terhapus : Error " . mysqli_error($conn) . "');
         </sciprt>";
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
         <div class="content">
            <h2 class="mt-1">Data Mahasiswa</h2>

            <div class="row mt-3 table-surat">
               <div class="col-md-4">
                  <!-- <button type="button" class="btn btn-info tombolTambahData" data-toggle="modal" data-target="#formModal-input">Buat Surat</button> -->
               </div>
               <div class="col-md-4 d-flex">
                  <a class="card-link" href="mahasiswa" class=" d-inline" for=""> <strong>Jurusan</strong> </a>
                  <ul class="">
                     <?php foreach ($jurusan as $data) : ?>
                        <li class="d-inline mr-5"><a class=" card-link" href="mahasiswa?jurusan=<?= $data['jurusan']; ?>"><?= $data['jurusan'] ?></a></li>
                     <?php endforeach; ?>
                  </ul>
               </div>
               <div class="col-lg-4">
                  <form action="" method="post">
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari Mahasiswa..." name="keyword" id="keyword" autocomplete="off">
                        <div class="input-group-append">
                           <button class="btn btn-outline-info" type="submit" id="search_btn" name="search_btn">Cari</button>
                        </div>
                     </div>
                  </form>
               </div>

               <table class="table mt-3">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>NPM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jurusan</th>
                        <th>Semester</th>
                        <!-- <th>Email</th> -->
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (isset($_GET['jurusan'])) : ?>
                        <?php $i = 1;
                        foreach ($mahasiswa_filter as $data) : ?>
                           <tr>
                              <th><?= $i; ?></th>
                              <td align="center"><strong><?= $data['npm'] ?></strong></td>
                              <td class="d-flex mt-2">
                                 <?php if (trim($data['foto_profil'] == '')) : ?>
                                    <div class="d-flex justify-content-center overflow-hidden align-self-center mr-3" style="width: 3em; height:3em; border-radius:400em;">
                                       <img class="d-inline-block align-self-center" style="width:4em;" src="../images/guest_user.png" alt="guest">
                                    </div>
                                 <?php else : ?>
                                    <div class="d-flex justify-content-center overflow-hidden align-self-center mr-3" style="width: 3em; height:3em; border-radius:0.5em;">
                                       <img class="d-inline-block align-self-center" style="width:4em;" src="../images/<?= $data['npm'] ?>/<?= $data['foto_profil'] ?>" alt="profile">
                                    </div>
                                 <?php endif; ?>
                                 <a class="card-link align-self-center" style="font-weight: 500;" href="detail_mahasiswa?npm=<?= $data['npm'] ?>"><?= $data['nama_mhs'] ?></a>
                              </td>
                              <td align="center"><?= $data['jurusan'] ?></td>
                              <td align="center"><?= $data['semester'] ?></td>
                              <td width="10%" class=" text-center">
                                 <a class="badge badge-pill badge-primary ml-1" href="detail_mahasiswa?npm=<?= $data['npm'] ?>">Detail</a>
                                 <a class="badge badge-pill badge-success ml-1 sunting-mhs-btn" data-toggle="modal" data-target="#form-update" href="mahasiswa?update=<?= $data['npm'] ?>" data-npm="<?= $data['npm'] ?>" data-nama_mhs="<?= $data['nama_mhs'] ?>" data-jurusan="<?= $data['jurusan'] ?>" data-semester="<?= $data['semester'] ?>" data-email="<?= $data['email'] ?>" data-foto_profil_lama="<?= $data['foto_profil'] ?>">Update</a>
                                 <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="mahasiswa?delete=<?= $data['npm'] ?>">Hapus</a>
                              </td>
                           </tr>
                        <?php $i++;
                        endforeach; ?>
                     <?php else : ?>
                        <?php $i = 1;
                        foreach ($mahasiswa as $data) : ?>
                           <tr>
                              <th><?= $i; ?></th>
                              <td align="center"><strong><?= $data['npm'] ?></strong></td>
                              <td class="d-flex mt-2">
                                 <?php if (trim($data['foto_profil'] == '')) : ?>
                                    <div class="d-flex justify-content-center overflow-hidden align-self-center mr-3" style="width: 3em; height:3em; border-radius:400em;">
                                       <img class="d-inline-block align-self-center" style="width:4em;" src="../images/guest_user.png" alt="guest">
                                    </div>
                                 <?php else : ?>
                                    <div class="d-flex justify-content-center overflow-hidden align-self-center mr-3" style="width: 3em; height:3em; border-radius:0.5em;">
                                       <img class="d-inline-block align-self-center" style="width:4em;" src="../images/<?= $data['npm'] ?>/<?= $data['foto_profil'] ?>" alt="profile">
                                    </div>
                                 <?php endif; ?>
                                 <a class="card-link align-self-center" style="font-weight: 500;" href="detail_mahasiswa?npm=<?= $data['npm'] ?>"><?= $data['nama_mhs'] ?></a>
                              </td>
                              <td align="center"><?= $data['jurusan'] ?></td>
                              <td align="center"><?= $data['semester'] ?></td>
                              <td width="10%" class=" text-center">
                                 <a class="badge badge-pill badge-primary ml-1" href="detail_mahasiswa?npm=<?= $data['npm'] ?>">Detail</a>
                                 <a class="badge badge-pill badge-success ml-1 sunting-mhs-btn" data-toggle="modal" data-target="#form-update" href="mahasiswa?update=<?= $data['npm'] ?>" data-npm="<?= $data['npm'] ?>" data-nama_mhs="<?= $data['nama_mhs'] ?>" data-jurusan="<?= $data['jurusan'] ?>" data-semester="<?= $data['semester'] ?>" data-email="<?= $data['email'] ?>" data-foto_profil_lama="<?= $data['foto_profil'] ?>">Update</a>
                                 <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="mahasiswa?delete=<?= $data['npm'] ?>">Hapus</a>
                              </td>
                           </tr>
                        <?php $i++;
                        endforeach; ?>
                     <?php endif; ?>
                  </tbody>
               </table>
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
                           <input type="text" class="form-control" id="npm" name="npm" placeholder="NPM" disabled>
                        </div>
                        <div class="col-12">
                           <label for="nama_mhs" class="form-label">Nama Lengkap</label>
                           <input type="text" class="form-control" id="nama_mhs" name="nama_mhs" placeholder="Nama Mahasiswa">
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
                           <input type="number" class="form-control" id="semester" name="semester" placeholder="Semester">
                        </div>
                        <div class=" col-12">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" id="email" name="email" placeholder="mahasiswa@mail.com">
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
                  <button type="submit" name="update_mhs" id="update_mhs" class="btn btn-info modal-button w-25">UPDATE</button>
               </div>
               </form>
               <?php mahasiswaUpdated(); ?>
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
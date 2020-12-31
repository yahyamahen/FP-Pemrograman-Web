<?php
session_start();
require_once "function.php";
require_once "model.php";

$kategori = read("SELECT kategori FROM surat LIMIT 2;");
$surat = read("SELECT * FROM surat WHERE npm = '$npm'");

if (isset($_POST['search_btn'])) {
   $key = $_POST['keyword'];
   $surat = read("SELECT * FROM surat WHERE 
   (kategori LIKE '%$key%' OR 
   judul_surat LIKE '%$key%' OR
   perusahaan LIKE '%$key%') && npm = '$npm';");
}

if (isset($_GET['kategori'])) {
   $ktg = $_GET['kategori'];
   $surat_filter = read("SELECT * FROM surat WHERE npm = '$npm' && kategori = '$ktg' ;");
   if (isset($_POST['search_btn'])) {
      $key = $_POST['keyword'];
      $surat_filter = read("SELECT * FROM surat WHERE kategori = '$ktg' && 
		(judul_surat LIKE '%$key%' OR
		perusahaan LIKE '%$key%') AND npm = '$npm';");
      echo $npm;
   }
}

function suratNotice()
{
   global $conn;
   if (isset($_POST["input"])) {
      if (inputSurat($_POST) == 1) {
         echo
            "<script>
            alert('Surat Berhasil Ditambahkan');
            document.location.href = 'home';
         </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "'</script>;";
         echo mysqli_error($conn);
      }
   }

   if (isset($_POST["update"])) {
      if (updateSurat($_POST) == 1) {
         echo
            "<script>
               alert('Surat Berhasil Diupdate');
               document.location.href = 'home';
            </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "'</script>;";
         echo mysqli_error($conn);
      }
   }
}

if (isset($_GET["delete"])) {
   $id = $_GET['delete'];
   $npm = $_SESSION["npm"];
   if (delete_surat($npm, $id) > 0) {
      echo
         "<script>
            alert('Surat Berhasil Dihapus');
            document.location.href='home';
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
   <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
   <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> -->

   <title>SiPesan</title>
</head>

<body>
   <div class="row">
      <?php require_once "sidebar.php" ?>

      <div class="col-md-10">
         <div class="content">
            <h2 class="mt-1">SiPesan (Sistem Informasi Surat Pengantar Perusahaan)</h2>
            <div class="profile-details d-flex mt-4">
               <?php foreach ($mahasiswa as $mhs) : ?>
                  <div class="d-flex justify-content-center overflow-hidden align-self-center mb-4" style="width: 8em; height:8em; border-radius:400em;">
                     <img class="d-inline-block align-self-center" style="width:8em;" src="images/<?= $mhs['npm'] ?>/<?= $mhs['foto_profil'] ?>" alt="profile">
                  </div>
                  <table cellspacing="0px" cellpadding="1px" border="0px" class="ml-4 mt-2">
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

            <div class="row mt-3 table-surat">
               <div class="col-md-4">
                  <button type="button" class="btn btn-info tombolTambahData" data-toggle="modal" data-target="#formModal-input">Buat Surat</button>
               </div>
               <div class="col-md-4 d-flex">
                  <a class="card-link" href="home" class=" d-inline" for=""> <strong>Kategori</strong> </a>
                  <ul class="">
                     <?php foreach ($kategori as $data) : ?>
                        <li class="d-inline mr-4"><a class=" card-link" href="home?kategori=<?= $data['kategori']; ?>"><?= $data['kategori'] ?></a></li>
                     <?php endforeach; ?>
                  </ul>
               </div>
               <div class="col-lg-4">
                  <form action="" method="post">
                     <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari Surat..." name="keyword" id="keyword" autocomplete="off">
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
                        <th>File Surat</th>
                        <th>Kategori</th>
                        <th>Perusahaan</th>
                        <th>Kegiatan</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (isset($_GET['kategori'])) : ?>
                        <?php $i = 1;
                        foreach ($surat_filter as $data) : ?>
                           <tr>
                              <th><?= $i; ?></th>
                              <td><?= $data['judul_surat'] ?></td>
                              <td align="center"><?= $data['kategori'] ?></td>
                              <td align="center"><?= $data['perusahaan'] ?></td>
                              <td width="20%" class=" text-center">
                                 <a class="badge badge-pill badge-primary ml-1" href="surat?id=<?= $data['id'] ?>">Detail</a>
                                 <a class="badge badge-pill badge-success ml-1 tampilModalUbah" data-toggle="modal" data-target="#formModal-input" href="home?update=<?= $data['id'] ?>" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-perihal_lengkap="<?= $data['perihal_lengkap'] ?>">Update</a>
                                 <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="home?delete=<?= $data['id'] ?>">Hapus</a>
                              </td>
                           </tr>
                        <?php $i++;
                        endforeach; ?>
                     <?php else : ?>
                        <?php $i = 1;
                        foreach ($surat as $data) : ?>
                           <tr>
                              <th><?= $i; ?></th>
                              <td><?= $data['judul_surat'] ?></td>
                              <td align="center"><?= $data['kategori'] ?></td>
                              <td width="15%" align="center"><?= $data['perusahaan'] ?></td>
                              <td class=" text-center">
                                 <a class="badge badge-pill badge-primary ml-1" href="surat?id=<?= $data['id'] ?>">Detail</a>
                                 <a class="badge badge-pill badge-success ml-1 tampilModalUbah" data-toggle="modal" data-target="#formModal-input" href="home?update=<?= $data['id'] ?>" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-perihal_lengkap="<?= $data['perihal_lengkap'] ?>">Update</a>
                                 <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="home?delete=<?= $data['id'] ?>">Hapus</a>
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

      <!-- Modal -->
      <div class="modal fade" id="formModal-input" tabhome="-1" aria-labelledby="judulModal" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="judulModal">Buat Surat</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <form action="#" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="id" id="id">
                     <input type="hidden" name="npm" id="npm" value="<?= $npm; ?>">
                     <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori" name="kategori">
                           <option value="Studi" selected>Studi</option>
                           <option value="Magang">Magang</option>
                        </select>
                     </div>

                     <div class="form-group">
                        <label for="judul_surat">Judul Surat</label>
                        <input type="text" class="form-control" id="judul_surat" name="judul_surat" placeholder="Judul Surat">
                     </div>

                     <div class="form-group">
                        <label for="perusahaan">Perusahaan</label>
                        <input type="text" class="form-control" id="perusahaan" name="perusahaan" placeholder="perusahaan">
                     </div>

                     <div class="form-group">
                        <label for="perihal_lengkap">Perihal</label>
                        <textarea rows="4" class="form-control" id="perihal_lengkap" name="perihal_lengkap" placeholder="Perihal Lengkap"></textarea>
                        <p style="font-size: 0.9em;">Contoh : <br>
                           Menyatakan bahwa mahasiswa dengan data yang terlampir memohon untuk melakukan Praktik Kerja Lapangan pada pada perusahaan PT.DEF Kedelai mulai tanggal 15 Juli 2020 - 19 Desember 2020</p>
                     </div>

                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="input" class="btn btn-primary">Tambah Surat</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <?php suratNotice() ?>

   <script src="js/js/jquery-3.5.1.js"></script>
   <script src="js/js/jquery-3.5.1.min.js"></script>
   <script src="js/js/bootstrap.js"></script>
   <script src="js/js/bootstrap.min.js"></script>
   <!-- <script src="js/js/bootstrap.bundle.js"></script> -->
   <!-- <script src="js/js/bootstrap.bundle.min.js"></script> -->
   <script src="js/js/font-awesome.min.js"></script>

   <!-- Optional JavaScript; choose one of the two! -->

   <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->

   <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
   <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->

   <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
   <!-- <script src="https//code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
   <!-- <script src="https//cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script> -->
   <!-- <script src="https//cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script> -->

   <script src="js/script.js"></script>
   <script>
      $(function() {
         $('.tombolTambahData').on('click', function() {
            $('#judulModal').html('Buat Surat');
            $('.modal-footer button[type=submit]').html('Buat Surat');
            $('.modal-footer button[type=submit]').addClass('btn btn-primary');
            // $('#kategori').val('');
            $('#judul_surat').val('');
            $('#perusahaan').val('');
            $('#perihal_lengkap').val('');
         });

         $('.tampilModalUbah').on('click', function() {
            $('#judulModal').html('Ubah Surat');
            $('.modal-footer button[type=submit]').addClass('btn btn-success');
            $('.modal-footer button[type=submit]').html('Ubah Surat');
            $('.modal-footer button[type=submit]').attr('name', 'update');

            let id = $(this).data('id');
            let npm = $(this).data('npm');
            let judul_surat = $(this).data('judul_surat');
            let kategori = $(this).data('kategori');
            let perusahaan = $(this).data('perusahaan');
            let perihal_lengkap = $(this).data('perihal_lengkap');

            $('.modal-body #id').val(id);
            $('.modal-body #npm').val(npm);
            $('.modal-body #judul_surat').val(judul_surat);
            $('.modal-body #kategori').val(kategori);
            $('.modal-body #perusahaan').val(perusahaan);
            $('.modal-body #perihal_lengkap').val(perihal_lengkap);
         });
      });
   </script>
</body>

</html>
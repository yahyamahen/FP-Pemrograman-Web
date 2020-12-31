<?php
session_start();
require_once "function.php";
require_once "model.php";

$id = $_GET['id'];
$surat = read("SELECT * FROM surat WHERE id = '$id' && npm = '$npm';");

function suratNotice()
{
   global $conn;
   // if (isset($_POST["input"])) {
   //    if (inputSurat($_POST) == 1) {
   //       echo
   //          "<script>
   //          alert('Surat Berhasil Ditambahkan');
   //          document.location.href = 'home';
   //       </script>";
   //    } else {
   //       echo "<script> alert('Error :  " . mysqli_error($conn) . "'</script>;";
   //       echo mysqli_error($conn);
   //    }
   // }

   if (isset($_POST["update-surat"])) {
      $id = $_GET['id'];
      if (updateSurat($_POST) == 1) {
         echo
            "<script>
               alert('Surat Berhasil Diupdate');
               document.location.href = 'surat?id=" . $id . "';
            </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "'</script>;";
         echo mysqli_error($conn);
      }
   }
}

// if (isset($_GET["delete"])) {
//    $id = $_GET['delete'];
//    $npm = $_SESSION["npm"];
//    if (delete_surat($npm, $id) > 0) {
//       echo
//          "<script>
//             alert('Surat Berhasil Dihapus');
//             document.location.href='home';
//          </script>";
//    } else {
//       echo
//          "<script>
//             alert('Surat Tidak Berhasil Terhapus : Error " . mysqli_error($conn) . "');
//          </sciprt>";
//    }
// }
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

   <title>SiPesan</title>
</head>

<body>

   <div class="row">
      <?php require_once "sidebar.php" ?>

      <div class="col-md-10">
         <div class="detail-surat-section">
            <?php foreach ($surat as $data) : ?>
               <h2 class="mt-1" style="font-size: 1.5em;">SiPesan (Sistem Informasi Surat Pengantar Perusahaan)</h2>
               <div class="d-flex justify-content-between">
                  <p>Judul Surat : <?= $data['judul_surat'] ?></p>
                  <div class="">
                     <a class="badge badge-pill badge-info ml-1" style="font-size:1.4em" href="surat?id=<?= $data['id'] ?>">Cetak</a>
                     <a class="badge badge-pill badge-success ml-1 edit-surat-btn" data-toggle="modal" data-target="#formModal-update" href="" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-perihal_lengkap="<?= $data['perihal_lengkap'] ?>">Update</a>
                     <!-- <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="surat?delete=<?= $data['id'] ?>">Hapus</a> -->
                  <?php endforeach; ?>
                  </div>
               </div>
         </div>
         <div class="content">

         </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="formModal-update" tabhome="-1" aria-labelledby="judulModal" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="judulModal">Update Surat</h5>
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
                        <button type="submit" name="input" class="btn btn-success">Update Surat</button>
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
   <script src="js/script.js"></script>

   <script>
      $(function() {
         $('.edit-surat-btn').on('click', function() {
            $('#judulModal').html('Update Surat');
            $('.modal-footer button[type=submit]').addClass('btn btn-success');
            $('.modal-footer button[type=submit]').html('Update Surat');
            $('.modal-footer button[type=submit]').attr('name', 'update-surat');

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
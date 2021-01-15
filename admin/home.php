<?php
session_start();
require_once "function.php";
require_once "model.php";

$kategori = read("SELECT kategori FROM surat GROUP BY kategori;");
$surat = read("SELECT * FROM surat, mahasiswa WHERE surat.npm = mahasiswa.npm ORDER BY id DESC;");

if (isset($_POST['search_btn'])) {
   $key = $_POST['keyword'];
   $surat = read("SELECT * FROM surat, mahasiswa WHERE 
   (surat.npm LIKE '%$key%' OR
   mahasiswa.nama_mhs LIKE '%$key%' OR
   kategori LIKE '%$key%' OR 
   judul_surat LIKE '%$key%' OR
   perusahaan LIKE '%$key%' OR
   status_surat LIKE '%$key%' OR
   no_surat LIKE '%$key%') AND surat.npm = mahasiswa.npm ORDER BY id DESC;");
}

if (isset($_GET['kategori'])) {
   $ktg = $_GET['kategori'];
   $surat_filter = read("SELECT * FROM surat, mahasiswa WHERE kategori = '$ktg' AND surat.npm = mahasiswa.npm ORDER BY id DESC;");
   if (isset($_POST['search_btn'])) {
      $key = $_POST['keyword'];
      $surat_filter = read("SELECT * FROM surat, mahasiswa WHERE kategori = '$ktg' && 
		(surat.npm LIKE '%$key%' OR
      mahasiswa.nama_mhs LIKE '%$key%' OR
      judul_surat LIKE '%$key%' OR
		perusahaan LIKE '%$key%' OR
      status_surat LIKE '%$key%' OR
      no_surat LIKE '%$key%') AND surat.npm = mahasiswa.npm ORDER BY id DESC;");
   }
}

function suratNotice()
{
   global $conn;
   if (isset($_POST["input"])) {
      var_dump($_POST);
      if (inputSurat($_POST) == 1) {
         echo
         "<script?>
            alert('Surat Berhasil Ditambahkan');
            document.location.href = 'home';
         </script?>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "'</script>;";
         echo mysqli_error($conn);
      }
   }

   if (isset($_POST["validasi"])) {
      if (validasiSurat($_POST) > 0) {
         echo
         "<script>
            alert('Status Surat Terupdate');
            document.location.href = 'home';
         </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "');</script>;";
      }
   }

   if (isset($_POST["update"])) {
      if (updateSurat($_POST) > 0) {
         echo
         "<script>
               alert('Surat Berhasil Diupdate');
               document.location.href = 'home';
            </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "');</script>;";
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

if (isset($_POST['kirim_surat'])) {
   kirimSurat($_POST);
   echo
   "<script>
      alert('Surat terkirim pada email : " . $_POST['email'] . "');
   </script>";
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
            <h2 class="mt-1">Daftar Surat</h2>
            <div class="row mt-3 table-surat">
               <div class="col-md-4">
                  <!-- <button type="button" class="btn btn-info tombolTambahData" data-toggle="modal" data-target="#formModal-input">Buat Surat</button> -->
               </div>
               <div class="col-md-4 d-flex">
                  <a class="card-link" href="home" class=" d-inline" for=""> <strong>Kategori</strong> </a>
                  <ul class="">
                     <?php foreach ($kategori as $data) : ?>
                        <li class="d-inline mr-4"><a class=" card-link" href="home?kategori=<?= $data['kategori']; ?>"><?= $data['kategori'] ?></a></li>
                     <?php endforeach; ?>
                  </ul>
               </div>
               <div class="col-md-4">
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
                        <th>NPM</th>
                        <th>File Surat</th>
                        <th>Kategori</th>
                        <th>Perusahaan</th>
                        <th>Status Pengajuan</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if (isset($_GET['kategori'])) : ?>
                        <?php $i = 1;
                        foreach ($surat_filter as $data) : ?>
                           <tr>
                              <th><?= $i; ?></th>
                              <td width="16%" align="center"><a class="card-link" style="color: black; font-weight:500;" href="detail_mahasiswa?npm=<?= $data['npm'] ?>"><?= $data['npm'] ?></a><strong></strong> <br>
                                 <p style="font-size: 0.8em; line-height:1.4em;"><?= $data['nama_mhs'] ?></p>
                              </td>
                              <td><a class="card-link" style="font-weight: 500;" href="detail_surat?id=<?= $data['id'] ?>"><?= $data['judul_surat'] ?></a></td>
                              <td align="center"><?= $data['kategori'] ?></td>
                              <td align="center"><?= $data['perusahaan'] ?></td>
                              <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                                 <td style="line-height: 1em;" align="center"><strong><?= $data['status_surat'] ?></strong></td>
                              <?php else : ?>
                                 <td style="color: green;" align="center"><strong><?= $data['status_surat'] ?></strong> <br>
                                    <p style="font-size: 0.8em; color:black"><?= $data['no_surat'] ?></p>
                                 </td>
                              <?php endif; ?>
                              <td width="10%" class=" text-center">
                                 <!-- <a class="badge badge-pill badge-warning ml-1 tampilModalValidasi" href="detail_surat?id=<?= $data['id'] ?>" data-toggle="modal" data-target="#formModal-validasi" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-nama_mhs="<?= $data['nama_mhs'] ?>" data-email="<?= $data['email'] ?>" data-judul_surat=" <?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-status_surat="<?= $data['status_surat'] ?>" data-no_surat="<?= $data['no_surat'] ?>">Status</a> -->
                                 <?php if ($data['status_surat'] == 'Tervalidasi') : ?>
                                    <form action="" method="post">
                                       <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                       <input type="hidden" name="npm" value="<?= $data['npm'] ?>">
                                       <input type="hidden" name="nama_mhs" value="<?= $data['nama_mhs'] ?>">
                                       <input type="hidden" name="email" value="<?= $data['email'] ?>">
                                       <input type="hidden" name="kategori" value="<?= $data['kategori'] ?>">
                                       <input type="hidden" name="judul_surat" value="<?= $data['judul_surat'] ?>">
                                       <input type="hidden" name="perusahaan" value="<?= $data['perusahaan'] ?>">
                                       <input type="hidden" name="status_surat" value="<?= $data['status_surat'] ?>">
                                       <button type="submit" name="kirim_surat" class="btn badge badge-pill badge-primary ml-1" style="font-size:0.75em">Kirim</button>
                                    </form>
                                 <?php endif; ?>
                                 <a class="badge badge-pill badge-success ml-1 tampilModalUbah" data-toggle="modal" data-target="#formModal-input" href="home?update=<?= $data['id'] ?>" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-perihal_lengkap="<?= $data['perihal_lengkap'] ?>">Update</a>
                                 <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="home?delete=<?= $data['id'] ?>&npm=<?= $data['npm'] ?>">Hapus</a>
                              </td>
                           </tr>
                        <?php $i++;
                        endforeach; ?>
                     <?php else : ?>
                        <?php $i = 1;
                        foreach ($surat as $data) : ?>
                           <tr>
                              <th><?= $i; ?></th>
                              <td width=" 16%" align="center"><a class="card-link" style="color: black; font-weight:500;" href="detail_mahasiswa?npm=<?= $data['npm'] ?>"><?= $data['npm'] ?></a><strong></strong> <br>
                                 <p style="font-size: 0.8em; line-height:1.4em;"><?= $data['nama_mhs'] ?></p>
                              </td>
                              <td><a class="card-link" style="font-weight: 500;" href="detail_surat?id=<?= $data['id'] ?>"><?= $data['judul_surat'] ?></a></td>
                              <td align="center"><?= $data['kategori'] ?></td>
                              <td align="center"><?= $data['perusahaan'] ?></td>
                              <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                                 <td style="line-height: 1em;" align="center"><strong><?= $data['status_surat'] ?></strong></td>
                              <?php else : ?>
                                 <td style="color: green;" align="center"><strong><?= $data['status_surat'] ?></strong> <br>
                                    <p style="font-size: 0.8em; color:black"><?= $data['no_surat'] ?></p>
                                 </td>
                              <?php endif; ?>
                              <td width="10%" class=" text-center">
                                 <!-- <a class="badge badge-pill badge-warning ml-1 tampilModalValidasi" href="detail_surat?id=<?= $data['id'] ?>" data-toggle="modal" data-target="#formModal-validasi" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-email="<?= $data['email'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-status_surat="<?= $data['status_surat'] ?>" data-no_surat="<?= $data['no_surat'] ?>">Status</a> -->
                                 <?php if ($data['status_surat'] == 'Tervalidasi') : ?>
                                    <form action="" method="post">
                                       <input type="hidden" name="id" value="<?= $data['id'] ?>">
                                       <input type="hidden" name="npm" value="<?= $data['npm'] ?>">
                                       <input type="hidden" name="nama_mhs" value="<?= $data['nama_mhs'] ?>">
                                       <input type="hidden" name="email" value="<?= $data['email'] ?>">
                                       <input type="hidden" name="kategori" value="<?= $data['kategori'] ?>">
                                       <input type="hidden" name="judul_surat" value="<?= $data['judul_surat'] ?>">
                                       <input type="hidden" name="perusahaan" value="<?= $data['perusahaan'] ?>">
                                       <input type="hidden" name="status_surat" value="<?= $data['status_surat'] ?>">
                                       <button type="submit" name="kirim_surat" class="btn badge badge-pill badge-primary ml-1" style="font-size:0.75em">Kirim</button>
                                    </form>
                                 <?php endif; ?>
                                 <a class="badge badge-pill badge-success ml-1 tampilModalUbah" data-toggle="modal" data-target="#formModal-input" href="home?update=<?= $data['id'] ?>" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-perihal_lengkap="<?= $data['perihal_lengkap'] ?>">Update</a>
                                 <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="home?delete=<?= $data['id'] ?>&npm=<?= $data['npm'] ?>">Hapus</a>
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
   </div>

   <!-- Modal Update -->
   <div class=" modal fade" id="formModal-input" tabhome="-1" aria-labelledby="judulModal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="judulModal">Buat Surat</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="" method="post">
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

                  <!-- <label for="perusahaan">Anggota Mahasiswa</label>
                     <div class="form-group input-group" id="dynamic_field">
                        <input type="text" name="anggota_mhs[]" id="anggota_mhs" class="form-control" placeholder="Anggota Mahasiswa 1">
                        <input type="number" name="npm_anggota_mhs[]" id="npm_anggota_mhs" class="form-control ml-4" placeholder="NPM Anggota Mahasiswa 1">
                        <button type="button" name="add" id="add" class="btn btn-success ml-2 mb-3">+</button>
                     </div> -->

                  <div class="form-group">
                     <label for="perihal_lengkap">Perihal</label>
                     <textarea rows="4" class="form-control" id="perihal_lengkap" name="perihal_lengkap" placeholder="Perihal Lengkap"></textarea>
                     <p style="font-size: 0.9em;"> <strong>Contoh Perihal Magang : </strong> <br>
                        menyatakan bahwa mahasiswa dengan data yang terlampir memohon untuk melakukan Praktik Kerja Lapangan pada <span style="color: red;"><strong>nama perusahaan</strong></span> mulai dari tanggal <span style="color: red;"><strong>15 Juli 2020</strong></span> sampai dengan tanggal <span style="color: red;"><strong>19 Desember 2020</strong></span>.</p>
                     <p style="font-size: 0.9em;"> <strong>Contoh Perihal Studi : </strong> <br>
                        menyatakan bahwa mahasiswa dengan data yang terlampir memohon untuk melakukan studi pada <span style="color: red;"><strong>nama perusahaan</strong></span> untuk memenuhi persyaratan tugas dari <span style="color: red;"><strong> mata kuliah/skripsi </strong></span>yang sedang ditempuh mahasiswa.</p>
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

   <!-- Modal validasi -->
   <div class="modal fade" id="formModal-validasi" tabhome="-1" aria-labelledby="judulModal" aria-hidden="true">
      <div class="modal-dialog modal-md">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title ml-0" id="judulModal">VALIDASI SURAT</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="" method="post">
                  <input type="hidden" name="id" id="id">
                  <input type="hidden" name="npm" id="npm">
                  <input type="hidden" name="nama_mhs" id="nama_mhs">
                  <input type="hidden" name="email" id="email">
                  <input type="hidden" name="kategori" id="kategori">
                  <input type="hidden" name="judul_surat" id="judul_surat">
                  <input type="hidden" name="perusahaan" id="perusahaan">
                  <input type="hidden" name="no_surat" id="no_surat">

                  <div class="form-group">
                     <label for="kategori">Kategori</label>
                     <select class="form-control" id="kategori" name="kategori" disabled>
                        <option value="Studi" selected>Studi</option>
                        <option value="Magang">Magang</option>
                     </select>
                  </div>

                  <div class="form-group">
                     <label for="judul_surat">Judul Surat</label>
                     <input type="text" class="form-control" id="judul_surat" name="judul_surat" placeholder="Judul Surat" disabled>
                  </div>

                  <div class="form-group">
                     <label for="perusahaan">Perusahaan</label>
                     <input type="text" class="form-control" id="perusahaan" name="perusahaan" placeholder="perusahaan" disabled>
                  </div>

                  <div class="form-group">
                     <label for="status_surat">Status Surat</label>
                     <select class="form-control" id="status_surat" name="status_surat">
                        <option value="Dalam pengajuan" selected>Dalam pengajuan</option>
                        <option value="Tervalidasi">Tervalidasi</option>
                     </select>
                  </div>

                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" name="validasi" class="btn btn-warning">Validasi Surat</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <?php suratNotice() ?>

   <script src="../js/js/jquery-3.5.1.js"></script>
   <script src="../js/js/jquery-3.5.1.min.js"></script>
   <script src="../js/js/bootstrap.js"></script>
   <script src="../js/js/bootstrap.min.js"></script>
   <!-- <script src="../js/js/bootstrap.bundle.js"></script> -->
   <!-- <script src="../js/js/bootstrap.bundle.min.js"></script> -->
   <script src="../js/js/font-awesome.min.js"></script>
   <script src="js/script.js"></script>

   <script src="js/script.js"></script>
   <script>
      $(document).ready(function() {
         var i = 0;
         $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<div class="form-group input-group" id="row' + i + '"><input type="text" name="anggota_mhs[]" id="anggota_mhs" class="form-control" placeholder="Anggota Mahasiswa ' + (i + 1) + '"><input type="number" name="npm_anggota_mhs[]" id="npm_anggota_mhs" class="form-control ml-4" placeholder="NPM Anggota Mahasiswa ' + (i + 1) + '"><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove ml-2 ">X</button></div>');
         });

         $(document).on('click', '.btn_remove', function() {
            i--;
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
         });

      });

      $(function() {
         $('.tombolTambahData').on('click', function() {
            $('#judulModal').html('Buat Surat');
            $('.modal-footer button[type=submit]').html('Buat Surat');
            $('.modal-footer button[type=submit]').addClass('btn btn-info');
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

      $(function() {
         $('.tampilModalValidasi').on('click', function() {
            $('#judulModal').html('Ubah Surat');
            $('.modal-footer button[type=submit]').addClass('btn btn-warning');
            $('.modal-footer button[type=submit]').html('Validasi Surat');
            $('.modal-footer button[type=submit]').attr('name', 'validasi');

            let id = $(this).data('id');
            let npm = $(this).data('npm');
            let nama_mhs = $(this).data('nama_mhs');
            let email = $(this).data('email');
            let judul_surat = $(this).data('judul_surat');
            let kategori = $(this).data('kategori');
            let perusahaan = $(this).data('perusahaan');
            let status_surat = $(this).data('status_surat');

            $('.modal-body #id').val(id);
            $('.modal-body #npm').val(npm);
            $('.modal-body #nama_mhs').val(nama_mhs);
            $('.modal-body #email').val(email);
            $('.modal-body #judul_surat').val(judul_surat);
            $('.modal-body #kategori').val(kategori);
            $('.modal-body #perusahaan').val(perusahaan);
            $('.modal-body #status_surat').val(status_surat);
         });
      });
   </script>

</body>

</html>
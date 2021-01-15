<?php
session_start();
require_once "function.php";
require_once "model.php";

$id = $_GET['id'];
$surat = read("SELECT * FROM surat WHERE id = '$id' && npm = '$npm';");

function suratNotice()
{
   global $conn;
   if (isset($_POST["input"])) {
      if (inputSurat($_POST) > 0) {
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

   if (isset($_POST["update-surat"])) {
      $id = $_GET['id'];
      if (updateSurat($_POST) > 0) {
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

   <title>SiPesan</title>
</head>

<body>

   <div class="row">
      <div class="col-md-2 sidebar-outer">
         <?php require_once "sidebar.php" ?>
      </div>

      <div class="col-md-10">
         <?php foreach ($surat as $data) : ?>
            <?php if ($data['kategori'] == 'Magang') : ?>
               <div class="detail-surat-section">
                  <h2 class="mt-1" style="font-size: 1.5em;">SiPesan (Sistem Informasi Surat Pengantar Perusahaan)</h2>
                  <div class="text-center ml-n5 mt-5">
                     <p style="font-size: 1.1em;" class="mt-3">Kategori surat : <strong><?= $data['kategori'] ?></strong> </p>
                     <p style="font-size: 1.1em;" class="mt-n3">Judul Surat : <?= $data['judul_surat'] ?></p>
                     <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                        <p style="line-height: 1em; color:red;" align="center"><strong><?= $data['status_surat'] ?></strong></p>
                        <div>
                           <a class="badge badge-pill badge-success ml-1 edit-surat-btn" data-toggle="modal" data-target="#formModal-update" href="" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-perihal_lengkap="<?= $data['perihal_lengkap'] ?>" style="font-size:1em">Update</a>
                           <a class="badge badge-pill badge-info ml-1" style="font-size:1em" target="_blank" href="file_surat?id=<?= $_GET['id'] ?>">Cetak</a>
                           <!-- <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="surat?delete=<?= $data['id'] ?>">Hapus</a> -->
                        </div>
                     <?php else : ?>
                        <p style="color: green;" align="center"><strong><?= $data['status_surat'] ?></strong> <br>
                        <p style="font-size: 0.9em; color:black; margin-top:-1.4em;"><?= $data['no_surat'] ?></p>
                        </p>
                        <div>
                           <a class="badge badge-pill badge-info ml-1" style="font-size:1em" target="_blank" href="file_surat?id=<?= $_GET['id'] ?>">Cetak</a>
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
               <div class="content-surat ml-5" style="font-family: 'Times New Roman', Times, serif;">
                  <div class="d-flex justify-content-between" style="padding: 0.4cm 0.5cm 0.4cm 0.5cm; border-bottom: 3px solid black;">
                     <div class="d-flex justify-content-center overflow-hidden align-self-center mb-4" style="width: 8em; height:8em;">
                        <img src="images/logo_univ.png" alt="" class="d-inline-block align-self-center" style="width:7em;">
                     </div>
                     <div class="kop-header ml-2 mr-2" style="text-align: center;" class=" align-self-center">
                        <h4><strong> FAKULTAS ILMU KOMPUTER </strong></h4>
                        <h2><strong> UNIVERSITAS ROCKET SAKTI</strong></h2>
                        <p><strong>Jl. Sanusi Raya No.59-62, Konohagakure, Surabaya, Jawa Timur</strong></p>
                        <p><strong>Telp (0271) 3318112, Fax (0271) 192821</strong></p>
                        <p>email : <a href="" class="card-link"><strong>rocketsakti@univ.ac.id</strong> </a>, Website : <a href="" class="card-link ml-n1"><strong> www.rocketsaktiuniversity.ac.id</strong></a></p>
                     </div>
                     <div class=" d-flex justify-content-center overflow-hidden align-self-center mb-4" style="width: 8em; height:8em;">
                        <img src="images/faculty-logo.png" alt="" class="d-inline-block align-self-center" style="width:8em;">
                     </div>
                  </div>
                  <div class="no-surat mt-4 text-center">
                     <p style="font-weight:900; text-decoration:underline; font-size:1.4em;">SURAT PENGANTAR</p>
                     <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                        <p style="font-size:1.16em; color: red; font-style:italic;" class="mt-n4">No. Surat : Sedang divalidasi</p>
                     <?php else : ?>
                        <p style="font-size:1.16em;" class="mt-n4">Nomor : <?= $data['no_surat'] ?></p>
                     <?php endif; ?>
                  </div>
                  <div class="body-surat">
                     <div class="tujuan-surat mb-4">
                        <p> <strong>Yth.</strong> </p>
                        <p>Bapak/Ibu Pimpinan Perusahaan</p>
                        <p><strong><?= $data['perusahaan']; ?></strong></p>
                     </div>
                     <div class="isi-surat">
                        <p class="text-justify" style="text-indent: 3em;">Sehubungan dengan diadakannya program PKL(Praktik Kerja Lapangan) oleh program studi Informatika Universitas Rocket Sakti yang merupakan kegiatan wajib yang harus dipenuhi oleh mahasiswa untuk menyelesaikan syarat kompetensi dalam Program Studi Infromatika Universtias Rocket Sakti. </p>
                        <!-- <table cellspacing="0px" border="0px" class="ml-4 mb-4">
                           <?php foreach ($mahasiswa as $mhs) : ?>
                              <tr>
                                 <td width="40%">Nama</td>
                                 <td width="5%">:</td>
                                 <td><?= $mhs['nama_mhs'] ?></td>
                              </tr>
                              <tr>
                                 <td width="40%">NPM</td>
                                 <td width="5%">:</td>
                                 <td><?= $mhs['npm'] ?></td>
                              </tr>
                              <tr>
                                 <td width="40%">Jurusan</td>
                                 <td width="5%">:</td>
                                 <td><?= $mhs['jurusan'] ?></td>
                              </tr>
                              <tr>
                                 <td width="40%">Semester</td>
                                 <td width="5%">:</td>
                                 <td><?= $mhs['semester'] ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </table> -->
                        <p class="text-justify" style="text-indent: 3em;"> Bersama surat ini kami <?= $data['perihal_lengkap'] ?></p>

                        <p class="text-justify" style="text-indent: 3em;"> Demikian surat pengantar ini dibuat dengan sebenar-benarnya. Atas perhatian bapak/ibu Pimpinan <?= $data['perusahaan'] ?> kami ucapkan terimakasih.</p>

                        <div class="ttd d-flex col-5 float-right flex-column text-center mt-5">
                           <p>Mengetahui,</p>
                           <p class="mb-5 mt-n2" style="line-height: 1.3em;">Dekan <br> Fakultas Ilmu Komputer <br> Universitas Rocket Sakti</p>
                           <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                              <p class="mt-n3" style="border: 1px solid red; border-radius: 30em; font-size:0.8em; color: red; font-style:italic; transform:rotate(350deg)">Tanda tangan : Sedang divalidasi</p>
                              <p class="mt-4" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                              <p class="mt-n4"> <strong>NIP. 3250818108201</strong> </p>
                           <?php else : ?>
                              <img style="width: 14em; bottom: 0; margin:-3em 0em -3.4em -1em;" src="images/ttd_dekan_stempel.png" alt="">
                              <p class="mt-5" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                              <p class="mt-n4"> <strong>NIP. 3250818108201</strong> </p>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               </div>
            <?php else : ?>
               <div class="detail-surat-section">
                  <h2 class="mt-1" style="font-size: 1.5em;">SiPesan (Sistem Informasi Surat Pengantar Perusahaan)</h2>
                  <div class="text-center ml-n5 mt-5">
                     <p style="font-size: 1.1em;" class="mt-3">Kategori surat : <strong><?= $data['kategori'] ?></strong> </p>
                     <p style="font-size: 1.1em;" class="mt-n3">Judul Surat : <?= $data['judul_surat'] ?></p>
                     <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                        <p style="line-height: 1em; color:red;" align="center"><strong><?= $data['status_surat'] ?></strong></p>
                        <div>
                           <a class="badge badge-pill badge-success ml-1 edit-surat-btn" data-toggle="modal" data-target="#formModal-update" href="" data-id="<?= $data['id'] ?>" data-npm="<?= $data['npm'] ?>" data-judul_surat="<?= $data['judul_surat'] ?>" data-kategori="<?= $data['kategori'] ?>" data-perusahaan="<?= $data['perusahaan'] ?>" data-perihal_lengkap="<?= $data['perihal_lengkap'] ?>" style="font-size:1em">Update</a>
                           <a class="badge badge-pill badge-info ml-1" style="font-size:1em" target="_blank" href="file_surat?id=<?= $_GET['id'] ?>">Cetak</a>
                           <!-- <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="surat?delete=<?= $data['id'] ?>">Hapus</a> -->
                        </div>
                     <?php else : ?>
                        <p style="color: green;" align="center"><strong><?= $data['status_surat'] ?></strong> <br>
                        <p style="font-size: 0.9em; color:black; margin-top:-1.4em;"><?= $data['no_surat'] ?></p>
                        </p>
                        <div>
                           <a class="badge badge-pill badge-info ml-1" style="font-size:1em" target="_blank" href="file_surat?id=<?= $_GET['id'] ?>">Cetak</a>
                           <!-- <a class="badge badge-pill badge-danger ml-1" onclick="return confirm('Anda Yakin?');" href="surat?delete=<?= $data['id'] ?>">Hapus</a> -->
                        </div>
                     <?php endif; ?>
                  </div>
               </div>
               <div class="content-surat ml-5" style="font-family: 'Times New Roman', Times, serif;">
                  <div class="d-flex justify-content-between" style="padding: 0.4cm 0.5cm 0.4cm 0.5cm; border-bottom: 3px solid black;">
                     <div class="d-flex justify-content-center overflow-hidden align-self-center mb-4" style="width: 8em; height:8em;">
                        <img src="images/logo_univ.png" alt="" class="d-inline-block align-self-center" style="width:7em;">
                     </div>
                     <div class="kop-header ml-2 mr-2" style="text-align: center;" class=" align-self-center">
                        <h4><strong> FAKULTAS ILMU KOMPUTER </strong></h4>
                        <h2><strong> UNIVERSITAS ROCKET SAKTI</strong></h2>
                        <p><strong>Jl. Sanusi Raya No.59-62, Konohagakure, Surabaya, Jawa Timur</strong></p>
                        <p><strong>Telp (0271) 3318112, Fax (0271) 192821</strong></p>
                        <p>email : <a href="" class="card-link"><strong>rocketsakti@univ.ac.id</strong> </a>, Website : <a href="" class="card-link ml-n1"><strong> www.rocketsaktiuniversity.ac.id</strong></a></p>
                     </div>
                     <div class=" d-flex justify-content-center overflow-hidden align-self-center mb-4" style="width: 8em; height:8em;">
                        <img src="images/faculty-logo.png" alt="" class="d-inline-block align-self-center" style="width:8em;">
                     </div>
                  </div>
                  <div class="no-surat mt-4 text-center">
                     <p style="font-weight:900; text-decoration:underline; font-size:1.4em;">SURAT PENGANTAR</p>
                     <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                        <p style="font-size:1.16em; color: red; font-style:italic;" class="mt-n4">No. Surat : Sedang divalidasi</p>
                     <?php else : ?>
                        <p style="font-size:1.16em;" class="mt-n4">Nomor : <?= $data['no_surat'] ?></p>
                     <?php endif; ?>
                  </div>
                  <div class="body-surat">
                     <div class="tujuan-surat mb-4">
                        <p> <strong>Yth.</strong> </p>
                        <p>Bapak/Ibu Pimpinan Perusahaan</p>
                        <p><strong><?= $data['perusahaan']; ?></strong></p>
                     </div>
                     <div class="isi-surat">
                        <p class="text-justify" style="text-indent: 3em;">Sehubungan dengan ditinjaunya keperluan studi eksternal oleh mahasiswa dengan pihak perusahaan.</p>
                        <!-- <table cellspacing="0px" border="0px" class="ml-4 mb-4">
                           <?php foreach ($mahasiswa as $mhs) : ?>
                              <tr>
                                 <td width="40%">Nama</td>
                                 <td width="5%">:</td>s
                                 <td><?= $mhs['nama_mhs'] ?></td>
                              </tr>
                              <tr>
                                 <td width="40%">NPM</td>
                                 <td width="5%">:</td>
                                 <td><?= $mhs['npm'] ?></td>
                              </tr>
                              <tr>
                                 <td width="40%">Jurusan</td>
                                 <td width="5%">:</td>
                                 <td><?= $mhs['jurusan'] ?></td>
                              </tr>
                              <tr>
                                 <td width="40%">Semester</td>
                                 <td width="5%">:</td>
                                 <td><?= $mhs['semester'] ?></td>
                              </tr>
                           <?php endforeach; ?>
                        </table> -->
                        <p class="text-justify" style="text-indent: 3em;"> Maka bersama surat ini kami <?= $data['perihal_lengkap'] ?></p>

                        <p class="text-justify" style="text-indent: 3em;"> Demikian surat pengantar ini dibuat dengan sebenar-benarnya. Atas perhatian bapak/ibu Pimpinan <?= $data['perusahaan'] ?> kami ucapkan terimakasih.</p>

                        <div class="ttd d-flex col-5 float-right flex-column text-center mt-5">
                           <p>Mengetahui,</p>
                           <p class="mb-5 mt-n2" style="line-height: 1.3em;">Dekan <br> Fakultas Ilmu Komputer <br> Universitas Rocket Sakti</p>
                           <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                              <p class="mt-n3" style="border: 1px solid red; border-radius: 30em; font-size:0.8em; color: red; font-style:italic; transform:rotate(350deg)">Tanda tangan : Sedang divalidasi</p>
                              <p class="mt-4" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                              <p class="mt-n4"> <strong>NIP. 3250818108201</strong> </p>
                           <?php else : ?>
                              <img style="width: 14em; bottom: 0; margin:-3em 0em -3.4em -1em;" src="images/ttd_dekan_stempel.png" alt="">
                              <p class="mt-5" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                              <p class="mt-n4"> <strong>NIP. 3250818108201</strong> </p>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               </div>
            <?php endif; ?>
         <?php endforeach; ?>
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
               <form action="#" method="post">
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
                     <p style="font-size: 0.9em;"> <strong>Contoh Perihal Magang : </strong> <br>
                        menyatakan bahwa mahasiswa dengan data yang terlampir memohon untuk melakukan Praktik Kerja Lapangan pada <span style="color: red;"><strong>nama perusahaan</strong></span> mulai dari tanggal <span style="color: red;"><strong>15 Juli 2020</strong></span> sampai dengan tanggal <span style="color: red;"><strong>19 Desember 2020</strong></span>.</p>
                     <p style="font-size: 0.9em;"> <strong>Contoh Perihal Studi : </strong> <br>
                        menyatakan bahwa mahasiswa dengan data yang terlampir memohon untuk melakukan studi pada <span style="color: red;"><strong>nama perusahaan</strong></span> untuk memenuhi persyaratan tugas dari <span style="color: red;"><strong> mata kuliah/skripsi </strong></span>yang sedang ditempuh mahasiswa.</p>
                  </div>

                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" name="input" class="btn btn-success">Update Surat</button>
                  </div>
               </form>
               <?php suratNotice() ?>
            </div>
         </div>
      </div>
   </div>

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
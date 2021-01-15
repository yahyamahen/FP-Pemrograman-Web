<?php
session_start();
require_once "function.php";
require_once "model.php";
require_once "../vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf();
ob_start();

if (isset($_POST['kirim_surat'])) {
   $id = $_POST['id'];
   $surat = read("SELECT * FROM surat WHERE id = '$id';");
}

if (isset($_GET['id'])) {
   $id = $_GET['id'];
   $surat = read("SELECT * FROM surat WHERE id = '$id';");
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
   <link rel="stylesheet" href="../css/style.css">

   <title>SiPesan</title>
</head>

<body>
   <?php foreach ($surat as $data) : ?>
      <?php if ($data['kategori'] == 'Magang') : ?>
         <div class="margin-surat" style="font-family: 'Times New Roman', Times, serif;">
            <div class="d-flex justify-content-between flex-row header" style="padding: 0.4cm 0.5cm 0.4cm 0.5cm; border-bottom: 3px solid black;">
               <div class="logo-univ d-flex justify-content-center overflow-hidden align-self-center mb-4 float-left" style="width: 6.5em; height:6.5em;">
                  <img src="../images/logo_univ.png" alt="" class="d-inline-block align-self-center" style="width:6.5em;">
               </div>
               <div class="header-kop text-center" style="margin-right:6.5em;">
                  <h4><strong> FAKULTAS ILMU KOMPUTER </strong></h4>
                  <h2><strong> UNIVERSITAS ROCKET SAKTI</strong></h2>
                  <p><strong>Jl. Sanusi Raya No.59-62, Konohagakure, Surabaya, Jawa Timur</strong></p>
                  <p><strong>Telp (0271) 3318112, Fax (0271) 192821</strong></p>
                  <p style="font-size: 0.8em;">email : <a href="" class=" card-link"><strong>rocketsakti@univ.ac.id</strong> </a>, Website : <a href="" class="card-link ml-n1"><strong> www.rocketsaktiuniversity.ac.id</strong></a></p>
               </div>
               <div class="logo-fakultas d-flex justify-content-center overflow-hidden align-self-center mb-4 float-right" style="width: 7em; height:7em; margin-top:-8.5em">
                  <img src="../images/faculty-logo.png" alt="" class="d-inline-block align-self-center" style="width:7em;">
               </div>
            </div>
            <div class="no-surat mt-4 text-center">
               <p style="font-weight:900; text-decoration:underline; font-size:1.3em;" class=" mb-n3">SURAT PENGANTAR</p>
               <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                  <p style="font-size:1em; color: red; font-style:italic; margin-top:-3px">No. Surat : Sedang divalidasi</p>
               <?php else : ?>
                  <p style="font-size:1em; margin-top:-4px" class="mt-n3">Nomor : <?= $data['no_surat'] ?></p>
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

                  <div class="ttd float-right mt-5 text-center" style="margin-left: 29em">
                     <p>Mengetahui,</p>
                     <p class="mb-5 mt-n2" style="line-height: 1.3em;">Dekan <br> Fakultas Ilmu Komputer <br> Universitas Rocket Sakti</p>
                     <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                        <p class="mt-n3" style="border: 1px solid red; border-radius: 30em; font-size:0.8em; color: red; font-style:italic; transform:rotate(350deg); width:17em">Tanda tangan : Sedang divalidasi</p>
                        <p class="mt-4 mb-n1" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                        <p> <strong>NIP. 3250818108201</strong> </p>
                     <?php else : ?>
                        <img style="width: 14em; bottom: 0; margin:-3em 0em -3.4em -1em;" src="../images/ttd_dekan_stempel.png" alt="">
                        <p class="mt-4 mb-n1" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                        <p class=""> <strong>NIP. 3250818108201</strong> </p>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
      <?php else : ?>
         <div class="margin-surat" style="font-family: 'Times New Roman', Times, serif;">
            <div class="d-flex justify-content-between flex-row header" style="padding: 0.4cm 0.5cm 0.4cm 0.5cm; border-bottom: 3px solid black;">
               <div class="logo-univ d-flex justify-content-center overflow-hidden align-self-center mb-4 float-left" style="width: 6.5em; height:6.5em;">
                  <img src="../images/logo_univ.png" alt="" class="d-inline-block align-self-center" style="width:6.5em;">
               </div>
               <div class="header-kop text-center" style="margin-right:6.5em;">
                  <h4><strong> FAKULTAS ILMU KOMPUTER </strong></h4>
                  <h2><strong> UNIVERSITAS ROCKET SAKTI</strong></h2>
                  <p><strong>Jl. Sanusi Raya No.59-62, Konohagakure, Surabaya, Jawa Timur</strong></p>
                  <p><strong>Telp (0271) 3318112, Fax (0271) 192821</strong></p>
                  <p style="font-size: 0.8em;">email : <a href="" class=" card-link"><strong>rocketsakti@univ.ac.id</strong> </a>, Website : <a href="" class="card-link ml-n1"><strong> www.rocketsaktiuniversity.ac.id</strong></a></p>
               </div>
               <div class="logo-fakultas d-flex justify-content-center overflow-hidden align-self-center mb-4 float-right" style="width: 7em; height:7em; margin-top:-8.5em">
                  <img src="../images/faculty-logo.png" alt="" class="d-inline-block align-self-center" style="width:7em;">
               </div>
            </div>
            <div class="no-surat mt-4 text-center">
               <p style="font-weight:900; text-decoration:underline; font-size:1.3em;" class=" mb-n3">SURAT PENGANTAR</p>
               <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                  <p style="font-size:1em; color: red; font-style:italic; margin-top:-3px">No. Surat : Sedang divalidasi</p>
               <?php else : ?>
                  <p style="font-size:1em; margin-top:-4px" class="mt-n3">Nomor : <?= $data['no_surat'] ?></p>
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

                  <div class="ttd float-right mt-5 text-center" style="margin-left: 29em">
                     <p>Mengetahui,</p>
                     <p class="mb-5 mt-n2" style="line-height: 1.3em;">Dekan <br> Fakultas Ilmu Komputer <br> Universitas Rocket Sakti</p>
                     <?php if ($data['status_surat'] == 'Dalam pengajuan') : ?>
                        <p class="mt-n3" style="border: 1px solid red; border-radius: 30em; font-size:0.8em; color: red; font-style:italic; transform:rotate(350deg); width:17em">Tanda tangan : Sedang divalidasi</p>
                        <p class="mt-4 mb-n1" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                        <p> <strong>NIP. 3250818108201</strong> </p>
                     <?php else : ?>
                        <img style="width: 14em; bottom: 0; margin:-3em 0em -3.4em -1em;" src="../images/ttd_dekan_stempel.png" alt="">
                        <p class="mt-4 mb-n1" style="text-decoration: underline;"> <strong>DR. Anugrah Mansyur, M.T</strong> </p>
                        <p class=""> <strong>NIP. 3250818108201</strong> </p>
                     <?php endif; ?>
                  </div>
               </div>
            </div>
         </div>
      <?php endif; ?>
   <?php endforeach; ?>

   <script src="../js/js/jquery-3.5.1.js"></script>
   <script src="../js/js/jquery-3.5.1.min.js"></script>
   <script src="../js/js/bootstrap.js"></script>
   <script src="../js/js/bootstrap.min.js"></script>
   <!-- <script src="../js/js/bootstrap.bundle.js"></script> -->
   <!-- <script src="../js/js/bootstrap.bundle.min.js"></script> -->
   <script src="../js/js/font-awesome.min.js"></script>
   <script src="../js/script.js"></script>

</body>

</html>

<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));

$path = "../images/" . $data['npm'] . "/surat";
if ($data['no_surat'] != null) {
   if (file_exists($path)) {
      // $mpdf->Output($data['npm'] . "_" . $data['no_surat'] . ".pdf", 'I');
      $mpdf->Output("../images/" . $data['npm'] . "/surat/" . $data['npm'] . "_valid" . ".pdf", "F");
   } else {
      mkdir($path, 0777, true);
      // $mpdf->Output($data['npm'] . "_" . $data['no_surat'] . ".pdf", 'I');
      $mpdf->Output("../images/" . $data['npm'] . "/surat/" . $data['npm'] . "_valid" . ".pdf", "F");
   }
} else {
   if (file_exists($path)) {
      // $mpdf->Output($data['npm'] . "_" . $data['no_surat'] . ".pdf", 'I');
      $mpdf->Output("../images/" . $data['npm'] . "/surat/" . $data['npm'] . "_belum_valid" . ".pdf", "F");
   } else {
      mkdir($path, 0777, true);
      // $mpdf->Output($data['npm'] . "_" . $data['no_surat'] . ".pdf", 'I');
      $mpdf->Output("../images/" . $data['npm'] . "/surat/" . $data['npm'] . "_belum_valid" . ".pdf", "F");
   }
}

if (isset($_POST['kirim_surat'])) {
   kirimSurat($_POST);
   echo
   "<script>
      alert('Surat terkirim pada email : " . $_POST['email'] . "');
   </script>";
}
// header("Location: detail_surat?id=" . $data['id']);

?>
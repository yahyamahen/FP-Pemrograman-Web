<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "../vendor/autoload.php";

function connection()
{
   $dbServer = 'localhost';
   $dbUser = 'root';
   $dbPass = '';
   $dbName = "sipesan";

   $conn = mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);

   if (!$conn)
      die('Koneksi gagal: ' . mysqli_error($conn));

   mysqli_select_db($conn, $dbName);
   return $conn;
}

$conn = connection();
static $no;

function read($query)
{
   global $conn;
   $result = mysqli_query($conn, $query);
   $record = [];

   while ($data = mysqli_fetch_assoc($result))
      $record[] = $data;

   if (mysqli_error($conn))
      echo mysqli_error($conn);

   return $record;
}

function registration($data)
{
   global $conn;
   $username = strtolower(stripslashes($data["username"]));
   $password = mysqli_real_escape_string($conn, $data["password"]);
   $password2 = mysqli_real_escape_string($conn, $data["password2"]);

   $result = mysqli_query($conn, "SELECT username FROM user WHERE username= '$username'");
   if (mysqli_fetch_assoc($result)) {
      echo "<script>
               alert('username sudah terdaftar'); 
            </script>";
      return false;
   }

   if ($password !== $password2) {
      echo "<script>
      alert('konfirmasi password tidak sesuai') </script>";
      return false;
   }

   $password = password_hash($password, PASSWORD_DEFAULT);
   // $password = md5($password);
   // var_dump($password);
   // die;

   mysqli_query($conn, "INSERT INTO user VALUES ('','$username','$password')");

   echo mysqli_error($conn);
   return mysqli_affected_rows($conn);
}

function validasiSurat($data)
{
   global $conn;
   $id = htmlspecialchars($data["id"]);
   $npm = htmlspecialchars($data["npm"]);
   $nama_mhs = htmlspecialchars($data["nama_mhs"]);
   $email = htmlspecialchars($data["email"]);
   $kategori = htmlspecialchars($data["kategori"]);
   $judul_surat = htmlspecialchars($data['judul_surat']);
   $perusahaan = htmlspecialchars($data['perusahaan']);
   $status_surat = htmlspecialchars($data['status_surat']);

   // exit;
   if ($status_surat == 'Tervalidasi') {
      if ($kategori == 'Magang') {
         $no_surat = "MG.$id/3/EKS/X/2020";
      } else if ($kategori == 'Studi') {
         $no_surat = "STD.$id/3/EKS/X/2020";
      }
   } else {
      $no_surat = null;
   }

   $query = "UPDATE surat SET status_surat = '$status_surat', no_surat = '$no_surat' WHERE npm = '$npm' && id = '$id';";
   mysqli_query($conn, $query);
   return mysqli_affected_rows($conn);
}

function kirimSurat($data)
{
   global $conn;
   $id = htmlspecialchars($data["id"]);
   $npm = htmlspecialchars($data["npm"]);
   $nama_mhs = htmlspecialchars($data["nama_mhs"]);
   $email = htmlspecialchars($data["email"]);
   $kategori = htmlspecialchars($data["kategori"]);
   $judul_surat = htmlspecialchars($data['judul_surat']);
   $perusahaan = htmlspecialchars($data['perusahaan']);
   $status_surat = htmlspecialchars($data['status_surat']);

   $mail = new PHPMailer;
   $mail->isSMTP();
   $mail->Host = "tls://smtp.gmail.com";
   $mail->SMTPAuth = true;
   $mail->Username = "kiky.mahendra21@gmail.com";
   $mail->Password = "It'sallconnected1";
   $mail->addAttachment("../images/" . $npm . "/surat/" .  $npm . "_valid"  . ".pdf");
   $mail->SMTPSecure = "ssl";
   $mail->Port = 587;
   $mail->From = "kiky.mahendra21@gmail.com";
   $mail->FromName = "Rizqi Yahya Mahendra";
   $mail->addAddress($email, $nama_mhs);
   $mail->isHTML(true);
   $mail->Subject = $judul_surat;
   $mail->Body    = "Surat $kategori $status_surat dari SiPesan";
   $mail->AltBody = "Termakasih, semoga beruntung di $perusahaan";

   if (!$mail->send()) {
      echo "
         <script> 
            alert('Mailer Error: " . $mail->ErrorInfo . "');
         </script>";
   } else {
      "<script>
         alert('Message sent successfully...');
      </script>";
   }
}

function delete_surat($npm, $id)
{
   global $conn;
   $query = "DELETE FROM surat WHERE npm = '$npm' && id = '$id';";
   mysqli_query($conn, $query);

   echo mysqli_error($conn);
   return mysqli_affected_rows($conn);
}


function updateSurat($data)
{
   global $conn;
   // $id = $data["id"];

   $id = htmlspecialchars($data["id"]);
   $npm = htmlspecialchars($data["npm"]);
   $kategori = htmlspecialchars($data["kategori"]);
   $judul_surat = htmlspecialchars($data['judul_surat']);
   $perusahaan = htmlspecialchars($data['perusahaan']);
   $perihal_lengkap = htmlspecialchars($data['perihal_lengkap']);

   if ($kategori == 'Magang') {
      $no_surat = "MG.12/49/MG/X/2020" . htmlspecialchars($data['id']);
   } else if ($kategori == 'Studi') {
      $no_surat = "STD.12/49/STD/X/2020" . htmlspecialchars($data['id']);
   }

   // $result = mysqli_query($conn, "SELECT id FROM surat WHERE id = '$id'");
   // if (mysqli_fetch_assoc($result)) {
   //    echo "<script>
   //             alert('Surat sudah Terdaftar');
   //          </script>";
   //    return false;
   // }

   // $row_no_surat = mysqli_query($conn, "SELECT no_surat FROM surat WHERE no_surat = '$no_surat'");
   // if ($row_no_surat == $no_surat) {
   //    echo "<script>
   //             alert('Surat sudah terdaftar');
   //          </script>";
   //    return false;
   // }

   $query = "UPDATE surat SET kategori = '$kategori', judul_surat = '$judul_surat', perusahaan = '$perusahaan', perihal_lengkap = '$perihal_lengkap' WHERE npm = '$npm' && id = '$id';";

   mysqli_query($conn, $query);
   return mysqli_affected_rows($conn);
}

function update($data)
{
   global $conn;
   $npm = $data["npm"];

   $nama_mhs = htmlspecialchars($data['nama_mhs']);
   $jurusan = htmlspecialchars($data['jurusan']);
   // $password = mysqli_real_escape_string($conn, htmlspecialchars($data['password']));
   // $password2 = mysqli_real_escape_string($conn, htmlspecialchars($data['password2']));
   $semester = htmlspecialchars($data['semester']);
   $email = htmlspecialchars($data['email']);
   $foto_profil_lama = htmlspecialchars($data['foto_profil_lama']);

   if ($_FILES['foto_profil']['error'] === 4) {
      $foto_profil = $foto_profil_lama;
   } else {
      $foto_profil = upload();
   }

   $query = "UPDATE mahasiswa SET nama_mhs = '$nama_mhs', jurusan = '$jurusan', semester = '$semester', email = '$email', foto_profil = '$foto_profil' WHERE npm = '$npm';";

   mysqli_query($conn, $query);
   echo mysqli_error($conn);
   echo "<br>" . mysqli_affected_rows($conn);
   return mysqli_affected_rows($conn);
}

function upload()
{
   $namaFile = $_FILES['foto_profil']['name'];
   $ukuranFile = $_FILES['foto_profil']['size'];
   $error = $_FILES['foto_profil']['error'];
   $tmpName = $_FILES['foto_profil']['tmp_name'];

   if ($error === 4) {
      echo
      "<script>
   		alert('Pilih gambar terlebih dahulu');
   	</script>";
      return false;
   }

   $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
   $ekstensiGambar = explode('.', $namaFile);
   $ekstensiGambar = strtolower(end($ekstensiGambar));
   if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
      echo
      "<script>
			alert('Yang diupload harus gambar');
		</script>";
      return false;
   }

   if ($ukuranFile > 5000000) {
      echo
      "<script>
			alert('File gambar minimal berukuran 4096kb');
		</script>";
      return false;
   }

   $namaFileBaru = $_POST['npm'] . "_" . date('d-M-Y', time()) . "_" . uniqid() . "." . $ekstensiGambar;

   $path = "../images/" . $_POST['npm'];
   if (file_exists($path)) {
      move_uploaded_file($tmpName, '../images/' . $_POST['npm'] . "/" . $namaFileBaru);
   } else {
      mkdir($path, 0777, true);
      move_uploaded_file($tmpName, '../images/' . $_POST['npm'] . "/" . $namaFileBaru);
   }

   echo $path . "/" . $namaFileBaru;
   return $namaFileBaru;
}

function updatePassword($data)
{
   global $conn;
   $npm = htmlspecialchars($data['npm_pass']);
   $password = mysqli_real_escape_string($conn, $data["password_baru"]);
   $password = password_hash($data['password_baru'], PASSWORD_DEFAULT);

   $query = "UPDATE mahasiswa SET pass = '$password' WHERE npm = '$npm';";

   mysqli_query($conn, $query);
   return mysqli_affected_rows($conn);
}

function delete_mhs($npm)
{
   global $conn;
   $query = "DELETE FROM surat WHERE npm = '$npm';";
   mysqli_query($conn, $query);
   $query = "DELETE FROM mahasiswa WHERE npm = '$npm';";
   mysqli_query($conn, $query);

   echo mysqli_error($conn);
   return mysqli_affected_rows($conn);
}

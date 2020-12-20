<?php
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

function read($query)
{
   global $conn;
   $result = mysqli_query($conn, $query);
   $record = [];

   while ($data = mysqli_fetch_assoc($result))
      $record[] = $data;

   return $record;
}

function registration($data)
{
   global $conn;

   $npm = strtolower(stripslashes($data["npm"]));
   $nama_mhs = htmlspecialchars($data['nama_mhs']);
   $jurusan = htmlspecialchars($data['jurusan']);
   $semester = htmlspecialchars($data['semester']);
   $email = htmlspecialchars($data['email']);
   $password = mysqli_real_escape_string($conn, $data["password"]);
   $password2 = mysqli_real_escape_string($conn, $data["password2"]);

   $result = mysqli_query($conn, "SELECT npm FROM users WHERE npm = '$npm'");

   if (mysqli_fetch_assoc($result)) {
      echo "<script>
               alert('NPM Sudah Terdaftar'); 
            </script>";
      return false;
   }

   if ($password !== $password2) {
      echo "<script>
               alert('Password Tidak Sesuai') 
            </script>";
      return false;
   }

   $password = password_hash($password, PASSWORD_DEFAULT);
   // $password = md5($password);
   // var_dump($password);
   // die;

   mysqli_query(
      $conn,
      "INSERT INTO users (npm, pass, nama_mhs, email, jurusan, semester) VALUES ( '$npm', '$password', '$nama_mhs', '$email', '$jurusan', '$semester')"
   );

   return mysqli_affected_rows($conn);
}

function getNPM()
{
}

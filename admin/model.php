<?php

if (!isset($_SESSION["admin"])) {
   echo "<script>
         alert('Login terlebih dahulu');
         document.location.href= 'login';
   </script>";
   exit;
}

if (isset($_SESSION['admin']) && isset($_SESSION['username'])) {
   $username = $_SESSION['username'];
   $user = read("SELECT * FROM user WHERE username = '$username'");
   $mahasiswa = read("SELECT * FROM mahasiswa WHERE npm = '$npm'");
   $surat = read("SELECT * FROM surat WHERE id = '$id'");
}

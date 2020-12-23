<?php

if (!isset($_SESSION["login"])) {
   echo "<script>
         alert('Login terlebih dahulu');
         document.location.href= 'login.php';
   </script>";
   exit;
}

if (isset($_SESSION['login']) && isset($_SESSION['npm'])) {
   $npm = $_SESSION['npm'];
   $mahasiswa = read("SELECT * FROM mahasiswa WHERE npm = '$npm'");
}

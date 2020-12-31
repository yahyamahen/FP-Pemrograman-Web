<?php
session_start();

if (!isset($_SESSION["login"])) {
   echo "<script>
         alert('Login terlebih dahulu');
         document.location.href= 'login';
   </script>";
   exit;
} else {
   echo
      "<script>
      alert('Terimakasih dan kembali lagi');
      document.location.href= 'login';
   </script>";

   $_SESSION = [];
   session_unset();
   session_destroy();

   setcookie('id', '', time() - 3600);
   setcookie('key', '', time() - 3600);

   exit;
}

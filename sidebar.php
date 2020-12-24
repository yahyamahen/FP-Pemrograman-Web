<div class="col-md-2 sidebar">
   <?php foreach ($mahasiswa as $mhs) : ?>
      <div class="profile d-flex flex-column">
         <img class="rounded-circle d-inline-block  mb-3" src="images/<?= $mhs['npm'] ?>/<?= $mhs['foto_profil'] ?>" alt="profile">
         <a class="card-link" href="akun"><?= $mhs['nama_mhs'] ?></a>
         <!-- <p><?= $mhs['posisi'] ?></p> -->
         <p>mahasiswa</p>
      </div>
   <?php endforeach; ?>

   <div class="menu-bar p-2 d-flex flex-column">
      <p class="mt-2 align-self-center">MENU</p>
      <ul class="list-group">
         <li class="list-inline mb-2"><a href="home" class=" card-link"><i class="fas fa-at mr-2"></i>Daftar Surat</a></li>
         <li class="list-inline mb-2"><a href="akun" class=" card-link"><i class="far fa-user mr-2"></i>Akun</a></li>
         <li class="list-inline mb-2"><a href="logout" class=" card-link"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
      </ul>

      <button class="btn btn-outline-primary hub-admin-btn">Hubungi Admin</button>
   </div>
</div>
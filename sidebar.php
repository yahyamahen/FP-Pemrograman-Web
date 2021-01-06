<div class="col-md-2 sidebar">
   <?php foreach ($mahasiswa as $data) : ?>
      <div class="profile d-flex flex-column">
         <?php if (trim($data['foto_profil'] == '')) : ?>
            <div class="d-flex justify-content-center overflow-hidden align-self-center" style="width: 6em; height:6em; border-radius:400em;">
               <img class="d-inline-block align-self-center" style="width:8em;" src="images/guest_user.png" alt="guest">
            </div>
         <?php else : ?>
            <div class="d-flex justify-content-center overflow-hidden align-self-center" style="width: 6em; height:6em; border-radius:400em;">
               <img class="d-inline-block" style="width:6em;" src="images/<?= $data['npm'] ?>/<?= $data['foto_profil'] ?>" alt="profile">
            </div>
         <?php endif; ?>
         <a class="card-link mt-3" href="akun"><?= $data['nama_mhs'] ?></a>
         <!-- <p><?= $data['posisi'] ?></p> -->
         <p>mahasiswa</p>
      </div>
   <?php endforeach; ?>

   <div class="menu-bar p-2 d-flex flex-column">
      <p class="mt-2 align-self-center">MENU</p>
      <ul class="list-group">
         <li class="list-inline mb-2"><a href="home" class=" card-link"><i class="fas fa-envelope mr-2"></i>Daftar Surat</a></li>
         <li class="list-inline mb-2"><a href="akun" class=" card-link"><i class="far fa-user mr-2"></i>Akun</a></li>
         <li class="list-inline mb-2"><a href="logout" class=" card-link"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
      </ul>

      <?php foreach ($mahasiswa as $data) : ?>
         <a href="https://wa.me/6285649572121?text=Halo%20Admin%20SiPesan%20Saya%20<?= $data['nama_mhs'] ?>%20NPM%20:%20<?= $data['npm'] ?>%20_ingin%20mengetik%20keluh%20kesah%20saya_" target="_blank" class="btn btn-outline-primary hub-admin-btn">Hubungi Admin</a>
      <?php endforeach; ?>
   </div>
</div>
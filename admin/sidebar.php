<div class="col-md-2 sidebar">
   <div class=" ml-4 text-center" style="color: grey; font-size:4em;"><i class="fas fa-user-lock mr-2"></i></div>
   <?php foreach ($user as $data) : ?>
      <div class="profile d-flex flex-column">
         <a class="card-link" href=""><?= $data['username'] ?></a>
         <p>Admin</p>
      </div>
   <?php endforeach; ?>

   <div class="menu-bar p-2 d-flex flex-column">
      <p class="mt-2 align-self-center">MENU</p>
      <ul class="list-group">
         <li class="list-inline mb-2"><a href="home" class=" card-link"><i class="fas fa-envelope  mr-2"></i>Daftar Surat</a></li>
         <li class="list-inline mb-2"><a href="mahasiswa" class=" card-link"><i class="fas fa-user-graduate mr-2"></i>Mahasiswa</a></li>
         <li class="list-inline mb-2"><a href="logout" class=" card-link"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
      </ul>
      <!-- <button class="btn btn-outline-primary hub-admin-btn">Hubungi Admin</button> -->
   </div>
</div>
$(function () {
   $('.tombolTambahData').on('click', function () {
      $('#judulModal').html('Buat Surat');
      $('.modal-footer button[type=submit]').html('Buat Surat');
      $('.modal-footer button[type=submit]').addClass('btn btn-primary');
      $('#kategori').val('');
      $('#judul_surat').val('');
      $('#perusahaan').val('');
      $('#perihal_lengkap').val('');     
   });

   $('.tampilModalUbah').on('click', function () {
      $('#judulModal').html('Ubah Surat');
      $('.modal-footer button[type=submit]').addClass('btn btn-success');
      $('.modal-footer button[type=submit]').html('Ubah Surat');
      $('.modal-footer button[type=submit]').attr('name', 'update');

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

// $(document).on('click', '#tombolModalUbah', function () {
//    let id = $(this).data('id');
//    let npm = $(this).data('npm');
//    let judul_surat = $(this).data('judul_surat');
//    let kategori = $(this).data('kategori');
//    let perusahaan = $(this).data('perusahaan');
//    let perihal_lengkap = $(this).data('perihal_lengkap');

//    $('.modal-body #id').val(id);
//    $('.modal-body #npm').val(npm);
//    $('.modal-body #judul_surat').val(judul_surat);
//    $('.modal-body #kategori').val(kategori);
//    $('.modal-body #perusahaan').val(perusahaan);
//    $('.modal-body #perihal lengkap').val(perihal lengkap);
// });

// $(function () {
//    $('.tombolTambahData').on('click', function () {
//       $('#judulModal').html('Buat Surat');
//       $('.modal-footer button[type=submit]').html('Buat Surat');
//       $('.modal-footer button[type=submit]').addClass('btn btn-primary');
//       $('#kategori').val('');
//       $('#judul_surat').val('');
//       $('#perusahaan').val('');
//       $('#perihal_lengkap').val('');     
//    });

//    $('.tampilModalUbah').on('click', function () {
//       $('#judulModal').html('Ubah Surat');
//       $('.modal-footer button[type=submit]').addClass('btn btn-success');
//       $('.modal-footer button[type=submit]').html('Ubah Surat');
//       $('.modal-footer button[type=submit]').attr('name', 'update');
//       // $('.modal-body form').attr('action', 'index.php');
//       // $('.fotoprofil input[type=file]').removeAttr('required');
      
//       const id = $(this).data('id');

//       $.ajax({
//          url: "index.php",
//          type: "POST",
//          data: {id : id},
//          // dataType: 'json',
//          success: function (data){
//             console.log(data.id);
//             // $('#id').val(data.id);
//             // $('#kategori').val(data.kategori);
//             // $('#judul_surat').val(data.judul_surat);
//             // $('#perusahaan').val(data.perusahaan);
//             // $('#perihal_surat').val(data.perihal_surat);   
//          }
//       });
//    });
// });
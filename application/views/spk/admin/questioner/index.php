<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Questioner</h3>
            </div>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-11">
                     <button class="btn btn-primary text-sm float-right mr-2" onclick="crtQuestioner()">Create Questioner</button>
                  </div>
                  <div class="col-1">
                     <button class="btn btn-outline-primary text-sm float-right" onclick="reload()">
                        <i class="fas fa-sync"></i>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section class="content">
      <div class="container-fluid">
         <div class="row mt-2">
            <div class="col-12">
               <div class="card">
                  <div class="card-body table-responsive text-sm">
                     <table id="example1" class="table table-head-fixed text-nowrap">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Code</th>
                              <th>Deadline</th>
                              <th>Status</th>
                              <th>Action</th>
                              <th>Rekap Nilai</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php $no = 1; foreach ($questioner as $row): ?>
                              <tr>
                                 <td><?= $no++ ?></td>
                                 <td><?= $row->code_questioner ?></td>
                                 <td><?= date('d-m-Y H:i', strtotime($row->deadline)) ?></td>
                                 <td>
                                    <?php if ($row->status == '1'): ?>
                                       <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                       <span class="badge badge-secondary">Non Active</span>
                                    <?php endif; ?>
                                 </td>
                                 <td>
                                    <a href="<?= base_url('questioner/monitoring/'.$row->id) ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Monitoring Belum Mengisi">
                                       <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="<?= base_url('questioner/toggle_status/'.$row->id) ?>" 
                                       class="btn btn-sm <?= $row->status == 1 ? 'btn-success' : 'btn-secondary' ?>" 
                                       title="<?= $row->status == 1 ? 'Nonaktifkan Kuisioner' : 'Aktifkan Kuisioner' ?>">
                                       <i class="fas <?= $row->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' ?>"></i>
                                    </a>

                                    <button onclick="window.location.href='<?= base_url('questioner/edit_questioner/'.$row->id) ?>'" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                     </button>
                                    <button title="Delete" onclick="deleteConfirm(<?= $row->id ?>);" class="btn btn-sm btn-danger">
                                       <i class="fa fa-trash"></i>
                                    </button>
                                 </td>
                                    <td>
                                   <a href="<?= base_url('questioner/rekap_nilai/' . $row->id) ?>" 
                                    class="btn btn-sm btn-info" 
                                    title="Rekap Nilai Rata-rata">
                                    <i class="fa fa-chart-bar"></i>
                                 </a>
                                 </td>

                              </tr>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

<script type="text/javascript">
   $(function() {
      $("#example1").DataTable({
         "responsive": true,
         "lengthChange": false,
         "autoWidth": false,
         "buttons": ["copy", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
   });

   function crtQuestioner() {
      window.location.href = "<?= base_url('questioner/new_questioner') ?>";
   }

   function get_questioner(id) {
      if (id) {
         window.location.href = "<?= base_url('questioner/edit_questioner/') ?>" + id;
      } else {
         alert('Oops.!! ID tidak ditemukan');
      }
   }

   function deleteConfirm(id) {
      Swal.fire({
         title: 'Are you sure?',
         text: "You won't be able to revert this!",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!',
         cancelButtonText: 'Cancel'
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               type: "post",
               url: "<?= base_url('questioner/delete_questioner') ?>",
               data: { id: id },
               dataType: "json",
               success: function(response) {
                  if (response.success) {
                     Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.success,
                        showConfirmButton: false,
                        timer: 1000
                     });
                     setTimeout(function() {
                        location.reload();
                     }, 1000);
                  } else {
                     Swal.fire('Error', response.error || 'Gagal menghapus data.', 'error');
                  }
               },
               error: function() {
                  Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
               }
            });
         }
      });
   }

   function reload() {
      location.reload();
   }
</script>

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
                              <th class="col-md-1 font-weight-normal text-sm">No</th>
                              <th class="font-weight-normal text-sm">Title</th>
                              <th class="font-weight-normal text-sm">Status</th>
                              <th class="col-md-2 font-weight-normal text-sm">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           foreach ($questioner as $row) { ?>
                              <tr>
                                 <td><?= $no++ ?></td>
                                 <?php 
                                    setlocale(LC_TIME, 'id_ID.utf8');
                                    $deadline = DateTime::createFromFormat('Y-m-d H:i:s', $row->deadline);
                                    $nama_bulan = strftime('%B', $deadline->getTimestamp()); // Contoh: Juni
                                    $nama_hari  = strftime('%A', $deadline->getTimestamp()); // Contoh: Jumat
                                    $tanggal    = $deadline->format('d');                   // 20
                                    $jam        = $deadline->format('H:i');
                                 ?>
                                 <td>
                                    Questioner <?= $nama_bulan ?><br>
                                    Deadline: <?= $nama_hari ?>, <?= $tanggal ?> <?= $nama_bulan ?> <?= $deadline->format('Y') ?> <?= $jam ?> WIB
                                </td>
                                 </td>
                                 <td><?= ($row->status == '1') ? 'Active' : 'Non Active'; ?></td>
                                 <td>
                                    <button title="Show" class="btn btn-sm btn-primary" onclick="show_questioner(<?= $row->id ?>);">
                                       <i class="fa fa-eye"></i>
                                    </button>
                                 </td>
                              </tr>
                           <?php } ?>
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

   function show_questioner($id){
    window.location.href = "<?= base_url('questioner/index/') ?>" + $id;
   }

   function reload() {
      location.reload();
   }
</script>
<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">User Role</h3>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="row mt-2">
         <div class="col-12">
            <div class="card">
               <div class="card-body table-responsive text-sm">
                  <table id="example1" class="table table-head-fixed text-nowrap">
                     <thead>
                        <tr>
                           <th class="col-md-1 font-weight-normal text-sm">No</th>
                           <th class="font-weight-normal text-sm">Role</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $no = 1;
                        foreach ($role as $row) { ?>
                           <tr>
                              <td><?= $no++ ?></td>
                              <td><?= $row->name ?></td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
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
</script>
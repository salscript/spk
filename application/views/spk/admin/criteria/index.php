<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Criteria</h3>
            </div>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-11">
                     <button class="btn btn-primary text-sm float-right mr-2" onclick="crtCriteria()">Create Criteria</button>
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
                              <th class="font-weight-normal text-sm">Code Criteria</th>
                              <th class="font-weight-normal text-sm">Aspect</th>
                              <th class="font-weight-normal text-sm">Name</th>
                              <th class="font-weight-normal text-sm">Persentase</th> 
                              <th class="font-weight-normal text-sm">Target</th> 
                              <th class="font-weight-normal text-sm">Factor</th>
                              <th class="col-md-2 font-weight-normal text-sm">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           foreach ($criteria as $row) { ?>
                              <tr>
                                 <td><?= $no++ ?></td>
                                 <td><?= $row->code ?></td>
                                 <td><?= $row->aspect ?></td>
                                 <td><?= $row->criteria ?></td>
                                 <td><?= $row->persentase ?></td>
                                 <td><?= $row->target ?></td>
                                 <td><?= $row->factor ?></td>
                                 <td>
                                    <button title="Update" class="btn btn-sm btn-success" onclick="get_criteria(<?= $row->id ?>);">
                                       <i class="fa fa-edit"></i>
                                    </button>
                                    <button title="Delete" onclick="deleteConfirm(<?= $row->id ?>);" class="btn btn-sm btn-danger">
                                       <i class="fa fa-trash"></i>
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

   function crtCriteria() {
      window.location.href = "<?= base_url('criteria/new_criteria') ?>"
   }

   function get_criteria(id) {
      var id_criteria = id
      if (id_criteria != "") {
         window.location.href = "<?= base_url('criteria/edit_criteria/') ?>" + id_criteria;
      } else {
         alert('Oops.!!');
      }
   }

   function deleteConfirm(id) {
      Swal.fire({
         title: 'Are you sure?',
         text: `You won't be able to revert this`,
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it!',
         cancelButtonText: 'Cancel'
      }).then((result) => {
         if (result.value) {
            $.ajax({
               type: "post",
               url: "<?php echo base_url('criteria/delete_criteria') ?>",
               data: {
                  id: id,
               },
               dataType: "json",
               success: function(response) {
                  if (response.success) {
                     Swal.fire({
                        icon: 'success',
                        title: 'konfirmasi',
                        text: response.success,
                        showCancelButton: false,
                        showConfirmButton: false
                     });
                     setTimeout(function() {
                        location.reload();
                     }, 1000);
                  }
               }
            });
         }
      })
   }

   function reload() {
      location.reload();
   }
</script>
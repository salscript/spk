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
                              <th class="col-md-1 font-weight-normal text-sm">No</th>
                              <th class="font-weight-normal text-sm">Code</th>
                              <th class="font-weight-normal text-sm">Deadline</th>
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
                                 <td><?= $row->code_questioner ?></td>
                                 <td><?= $row->deadline ?></td>
                                 <td></td>
                                 <td>
                                    <button title="Show" class="btn btn-sm btn-primary" onclick="show_questioner(<?= $row->id ?>);">
                                       <i class="fa fa-eye"></i>
                                    </button>
                                    <button title="Update" class="btn btn-sm btn-success" onclick="get_questioner(<?= $row->id ?>);">
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

   function crtQuestioner() {
      window.location.href = "<?= base_url('questioner/new_questioner') ?>"
   }

   function get_questioner(id) {
      if (id != "") {
         window.location.href = "<?= base_url('questioner/edit_questioner/') ?>" + id;
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
               url: "<?php echo base_url('questioner/delete_questioner') ?>",
               data: {
                  id_question: id,
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
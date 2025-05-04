<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">User</h3>
            </div>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-11">
                     <button class="btn btn-primary text-sm float-right mr-2" onclick="crtUser()">Create User</button>
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
                              <th class="col-ms-1 font-weight-normal text-sm">No</th>
                              <th class="font-weight-normal text-sm">Code User</th>
                              <th class="font-weight-normal text-sm">Nama</th>
                              <!-- <th class="font-weight-normal text-sm">Email</th> -->
                              <th class="font-weight-normal text-sm">Position</th>
                              <th class="font-weight-normal text-sm">Division</th>
                              <!-- <th class="font-weight-normal text-sm">Alamat</th>
                              <th class="font-weight-normal text-sm">Nomor Telepon</th> -->
                              <th class="font-weight-normal text-sm">Role</th> 
                              <th class="font-weight-normal text-sm">Status</th> 
                              <th class="col-ms-2 font-weight-normal text-sm">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           foreach ($user as $row) { ?>
                           <tr>
                              <td><?= $no++ ?></td>
                              <td><?= $row->code_user ?></td>
                              <td><?= $row->fullname ?></td>
                              <!-- <td><?= $row->email ?></td> -->
                              <td><?= $row->position_name ?></td>
                              <td>
                                 <?php foreach ($row->divisions as $div) { ?>
                                    <p class="m-0">- <?= $div->name ?></p>
                                 <?php } ?>
                              </td>
                              <!-- <td><?= $row->alamat ?></td>
                              <td><?= $row->nomortelepon ?></td> -->
                              <td><?= $row->role_name ?></td>
                              <td>
                                 <?php if ($row->status == '1') {
                                    echo 'Active';
                                 } else {
                                    echo 'Non Active';
                                 }
                                 ?>
                              </td>
                              <td>
                                 <button title="Update" class="btn btn-sm btn-success" onclick="get_user(<?= $row->id ?>);">
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

   function crtUser() {
      window.location.href = "<?= base_url('user/new_user') ?>"
   }

   function get_user(id) {
      var id_user = id
      if (id_user != "") {
         window.location.href = "<?= base_url('user/edit_user/') ?>" + id_user;
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
               url: "<?php echo base_url('user/delete_user') ?>",
               data: {
                  id_user: id,
               },
               dataType: "json",
               success: function(response) {
                  if (response.error) {
                        toastr.error(response.error);
                  }
                  
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
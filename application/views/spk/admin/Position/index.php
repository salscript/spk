<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Position</h3>
            </div>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-11">
                     <button class="btn btn-primary text-sm float-right mr-2" onclick="crtPosition()">Create Position</button>
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
                              <!-- <th class="col-md-1 font-weight-normal text-sm">No</th> -->
                              <th class="font-weight-normal text-sm">Name</th>
                              <!-- <th class="font-weight-normal text-sm">Role</th>  -->
                              <th class="font-weight-normal text-sm">Status</th>
                              <th class="col-md-2 font-weight-normal text-sm">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $no = 1;
                           foreach ($position as $key => $row) { ?>
                              <tr>
                                 <!-- <td><?= $no++ ?></td> -->
                                 <td class="text-sm">
                                    <div class="media align-items-center">
                                       <div class="avatar-wrapper2">
                                          <img src="<?php echo base_url('assets/back') ?><?= $row->avatar; ?>" class="img-size-32 img-circle">
                                       </div>
                                       <div class="media-body ml-2 ">
                                          <h4 class="dropdown-item-title text-sm mb-0 ">
                                             <?= $row->fullname; ?>
                                          </h4>
                                          <p class="text-sm text-muted mb-0"><?= $row->email; ?></p>
                                       </div>
                                    </div>
                                    <!-- <?= $row->fullname ?><br>
                                                <p class="text-black-50 font-weight-light text-sm"><i class="fas fa-envelope"></i> <?= $row->email ?></p> -->
                                 </td>
                                 <!-- <td>
                                    <?php if ($row->divisi_id == 0) {
                                       echo $row->role . ' - Client';
                                    } else {
                                       echo $row->role . ' - ' . $row->divisi;
                                    }
                                    ?>
                                 </td> -->
                                 <td>
                                    <?php if ($row->status == '1') {
                                       echo 'Active';
                                    } else {
                                       echo 'Non Active';
                                    }
                                    ?>
                                 </td>
                                 <td>
                                    <button title="Update" class="btn btn-sm btn-success" onclick="get_position(<?= $row->id ?>);">
                                       <i class="fa fa-edit"></i>
                                    </button>
                                    <!-- &nbsp; -->
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

   function crtPosition() {
      window.location.href = "<?= base_url('position/new_position') ?>"
   }

   function get_position(id) {
      var id_position = id
      if (id_position != "") {
         window.location.href = "<?= base_url('position/edit_position/') ?>" + id_position;
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
               url: "<?php echo base_url('position/deletePosition') ?>",
               data: {
                  id_position: id,
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
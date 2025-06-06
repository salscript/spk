<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder"><?= $title ?></h3>
            </div>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-11">
                     <button class="btn btn-primary text-sm float-right mr-2" onclick="back()">Back</button>
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
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_peer">
                        <div class="card">
                           <div class="card-body table-responsive text-sm">
                              <table id="example1" class="table table-head-fixed text-nowrap">
                                 <thead>
                                    <tr>
                                       <th class="col-md-1 font-weight-normal text-sm">No</th>
                                       <th class="font-weight-normal text-sm">Nama</th>
                                       <th class="font-weight-normal text-sm">Jabatan</th>
                                       <th class="font-weight-normal text-sm">Divisi</th>
                                       <th class="font-weight-normal text-sm">Status</th>
                                       <th class="font-weight-normal text-sm">Waktu Penilaian</th>
                                       <th class="col-md-2 font-weight-normal text-sm">Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                     <?php 
                                     $no = 1;
                                     foreach ($peer_questioners as $peer): ?>
                                        <tr class="<?= ($peer->status == 'completed') ? 'success' : 'warning' ?>">
                                            <td><?= $no++ ?></td>
                                            <td><?= $peer->fullname ?></td>
                                            <td><?= $peer->position_name ?></td>
                                            <td><?= $peer->division_name ?></td>
                                            <td>
                                                <?php if ($peer->status == 'completed'): ?>
                                                    <span class="label label-success">Selesai</span>
                                                <?php else: ?>
                                                    <span class="label label-warning">Belum Dinilai</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= $peer->created_on ? date('d/m/Y H:i', strtotime($peer->created_on)) : '-' ?>
                                            </td>
                                            <td>
                                                <?php if ($peer->status != 'completed'): ?>
                                                    <button class="btn btn-primary btn-sm" onclick="nilai_questioner(<?=$peer->id?>, <?=$questioner_id?>)">
                                                        <i class="fa fa-edit"></i> Nilai
                                                    </button>
                                                <?php else: ?>
                                                    <span class="badge bg-green"><i class="fa fa-check"></i> Selesai</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>   
                                    <?php endforeach; ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                    </div>
                    <?php if($is_pic || $is_hrd): ?>
                        <div class="tab-pane" id="tab_supervisor">
                            <div class="card">
                                <div class="card-body table-responsive text-sm">
                                    <table id="example1" class="table table-head-fixed text-nowrap">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1 font-weight-normal text-sm">No</th>
                                                <th class="font-weight-normal text-sm">Nama</th>
                                                <th class="font-weight-normal text-sm">Jabatan</th>
                                                <th class="font-weight-normal text-sm">Divisi</th>
                                                <th class="font-weight-normal text-sm">Status</th>
                                                <th class="font-weight-normal text-sm">Waktu Penilaian</th>
                                                <th class="col-md-2 font-weight-normal text-sm">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $no = 1;
                                                foreach ($supervisor_questioners as $supervisor): ?>
                                                <tr class="<?= ($supervisor->status == 'completed') ? 'success' : 'warning' ?>">
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $supervisor->fullname ?></td>
                                                    <td><?= $supervisor->position_name ?></td>
                                                    <td><?= $supervisor->division_name ?></td>
                                                    <td>
                                                        <?php if ($supervisor->status == 'completed'): ?>
                                                            <span class="label label-success">Selesai</span>
                                                        <?php else: ?>
                                                            <span class="label label-warning">Belum Dinilai</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supervisor->created_at ? date('d/m/Y H:i', strtotime($supervisor->created_at)) : '-' ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($supervisor->status != 'completed'): ?>
                                                            <a href="<?= site_url('questioner/supervisor/'.$supervisor->id) ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-edit"></i> Nilai
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="badge bg-green"><i class="fa fa-check"></i> Selesai</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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

   function nilai_questioner($evaluatee_id, $questioner_id){
    url = `questioner/peer?evaluatee_id=${$evaluatee_id}&questioner_id=${$questioner_id}`;
    window.location.href= "<?= base_url() ?>" + url;
   }

   function back(){
     window.location.href = "<?= base_url('questioner/questioner_user') ?>"
   }

   function reload() {
      location.reload();
   }
</script>

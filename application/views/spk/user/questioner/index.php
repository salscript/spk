<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Questioner</h3>
            </div>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-11"></div>
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
                          <?php if ($questioner): ?>
                            <?php
                           $row = $questioner;
                              setlocale(LC_TIME, 'id_ID.utf8');
                              $deadline = DateTime::createFromFormat('Y-m-d H:i:s', $row->deadline);
                              $nama_bulan = $deadline->format('F');
                              $nama_hari  = $deadline->format('l');
                              $tanggal    = $deadline->format('d');
                              $jam        = $deadline->format('H:i');
                              ?>
                               <tr>
                                 <td>1</td>
                                 <td>
                                       <div>Questioner <?= $nama_bulan ?></div>
                                       <div>Deadline: <?= $nama_hari ?>, <?= $tanggal ?> <?= $nama_bulan ?> <?= $deadline->format('Y') ?> <?= $jam ?> WIB</div>
                                       <div class="text-danger font-weight-bold" data-deadline="<?= str_replace(' ', 'T', $row->deadline) ?>" id="countdown-<?= $row->id ?>">
                                          ⏳ Menghitung waktu tersisa...
                                       </div>
                                 </td>
                                 <td>
                                       <span class="badge badge-success">Aktif</span>
                                 </td>
                                 <td>
                                  <button title="Isi Kuisioner" class="btn btn-sm btn-primary" onclick="show_questioner(<?= $row->id ?>);">
                                 <i class="fa fa-eye"></i>
                                 </button>
                                 </td>
                                 </tr>
                                 <?php else: ?>
                                    <tr>
                                       <td colspan="4" class="text-center">
                                             <div class="alert alert-warning m-0">
                                                <i class="fas fa-info-circle"></i> Tidak ada kuisioner aktif saat ini. Mungkin telah ditutup oleh admin atau melewati batas waktu.
                                             </div>
                                       </td>
                                    </tr>
                                    <?php endif; ?>
                                 </td>
                              </tr>
                           <?php  ?>
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

      // Inisialisasi tooltip
      $('[data-toggle="tooltip"]').tooltip();
   });

   function show_questioner(id){
      window.location.href = "<?= base_url('questioner/index/') ?>" + id;
   }

   function reload() {
      location.reload();
   }
   function calculateCountdown(deadline, elementId) {
    const now = new Date().getTime();
    const end = new Date(deadline).getTime();
    const distance = end - now;

    if (distance <= 0) {
        document.getElementById(elementId).innerText = "⛔ Kuisioner sudah ditutup.";
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

    let text = "⏳ Sisa waktu: ";
    if (days > 0) text += days + " hari ";
    if (hours > 0 || days > 0) text += hours + " jam ";
    text += minutes + " menit";

    document.getElementById(elementId).innerText = text;
}

function startCountdowns() {
    document.querySelectorAll('[data-deadline]').forEach(function (el) {
        const deadline = el.getAttribute('data-deadline');
        const elementId = el.getAttribute('id');

        calculateCountdown(deadline, elementId);
        setInterval(function () {
            calculateCountdown(deadline, elementId);
        }, 30000); // Update setiap 30 detik
    });
}

$(document).ready(function () {
    startCountdowns();
});

</script>

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
            <div class="table-responsive">
               <table class="table table-bordered table-striped table-hover">
                   <thead class="thead-dark">
                     <tr>
                        <th>No</th>
                        <th>Evaluator</th>
                        <th>Divisi Evaluator</th>
                        <th>Jabatan Evaluator</th>
                        <th>Level Evaluator</th>
                        <th>Evaluatee</th>
                        <th>Divisi Evaluatee</th>
                        <th>Jabatan Evaluatee</th>
                        <th>Level Evaluatee</th>
                        <th>Jenis Penilaian</th>
                        <th>Status</th>
                     </tr>
                  </thead>

                  <tbody>
                  <?php if (!empty($monitoring_data)): ?>
                     <?php $no = 1; foreach ($monitoring_data as $row): ?>
                        <tr>
                              <td><?= $no++ ?></td>

                              <td><?= htmlspecialchars($row['evaluator']->fullname) ?></td>
                              <td><?= htmlspecialchars($row['evaluator']->division_name ?? '-') ?></td>
                              <td><?= htmlspecialchars($row['evaluator']->position_name ?? '-') ?></td>
                              <td><?= htmlspecialchars($row['evaluator']->level_position ?? '-') ?></td>

                              <td><?= htmlspecialchars($row['evaluatee']->fullname) ?></td>
                              <td><?= htmlspecialchars($row['evaluatee']->division_name ?? '-') ?></td>
                              <td><?= htmlspecialchars($row['evaluatee']->position_name ?? '-') ?></td>
                              <td><?= htmlspecialchars($row['evaluatee']->level_position ?? '-') ?></td>

                              <td class="text-center">
                                 <?php if ($row['type'] === 'peer'): ?>
                                    <span class="badge badge-info">Rekan Kerja</span>
                                 <?php elseif ($row['type'] === 'supervisor'): ?>
                                    <span class="badge badge-primary">Atasan</span>
                                 <?php endif; ?>
                              </td>
                              <td class="text-center">
                                 <?php if ($row['status'] === 'completed'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                 <?php else: ?>
                                    <span class="badge badge-warning">Belum</span>
                                 <?php endif; ?>
                              </td>
                        </tr>
                     <?php endforeach; ?>
                  <?php else: ?>
                     <tr>
                        <td colspan="11" class="text-center text-muted">Belum ada data penilaian yang tersedia.</td>
                     </tr>
                  <?php endif; ?>
                  </tbody>
               </table>
            </div>
         </div>
         <script>
    // Kembali ke halaman sebelumnya atau ke fallback
    function back() {
        if (document.referrer !== "") {
            window.history.back();
        } else {
            window.location.href = "<?= base_url('questioner') ?>"; // fallback ke halaman form questioner
        }
    }

    // Reload halaman
    function reload() {
        location.reload();
    }

    // Konfirmasi aksi seperti hapus, submit ulang, dll
    function confirmAction(message, actionCallback) {
        if (confirm(message)) {
            actionCallback(); // jika user tekan OK
        }
    }

    // Contoh penggunaan confirmAction:
    // <button onclick="confirmAction('Apakah Anda yakin ingin menghapus data ini?', function() { window.location.href = '<?= base_url('delete/url') ?>' })">Hapus</button>

    // Notifikasi flash berbasis Bootstrap (opsional)
    <?php if($this->session->flashdata('success')): ?>
        alert("✅ <?= $this->session->flashdata('success'); ?>");
    <?php elseif($this->session->flashdata('error')): ?>
        alert("❌ <?= $this->session->flashdata('error'); ?>");
    <?php endif; ?>

    // Scroll ke atas otomatis saat reload (opsional)
    document.addEventListener("DOMContentLoaded", function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>


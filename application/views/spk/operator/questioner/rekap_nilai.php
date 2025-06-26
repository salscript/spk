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
         <div class="card">
            <div class="card-body">
               <!-- Filter Karyawan -->
               <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Filter Karyawan:</label>
                  <div class="col-sm-6">
                     <select class="form-control" id="filterKaryawan">
                        <option value="">Tampilkan Semua</option>
                        <?php
                        $seen = [];
                        foreach ($rekap as $r):
                           if (in_array($r->employee_name, $seen)) continue;
                           $seen[] = $r->employee_name;
                        ?>
                           <option value="<?= $r->employee_name ?>"><?= $r->employee_name ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
               </div>

               <!-- Tabel Rekap -->
               <div class="table-responsive">
                  <table id="rekapTable" class="table table-bordered table-striped">
                     <thead class="thead-dark text-sm">
                        <tr>
                           <th>Nama Karyawan</th>
                           <th>Kriteria Penilaian</th>
                           <th>Aspek</th>
                           <th>Jenis Penilaian</th>
                           <th>Jumlah Pertanyaan</th>
                           <th>Jumlah Penilai</th>
                           <th>Total Nilai</th>
                           <th>Nilai Rata-rata</th>
                           <!-- <th>Status</th> -->
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($rekap as $r): ?>
                           <tr>
                              <td><?= htmlspecialchars($r->employee_name) ?></td>
                              <td><?= htmlspecialchars($r->criteria_name) ?></td>
                              <td><?= htmlspecialchars($r->aspect_name) ?></td>
                              <td><?= $r->penilaian_type === 'peer' ? 'Rekan Kerja' : 'Atasan' ?></td>
                              <td><?= $r->jumlah_pertanyaan ?></td>
                              <td><?= $r->jumlah_penilai ?></td>
                              <td><?= $r->total_nilai ?></td>
                              <td>
                                 <?php
                                 $badge = ($r->avg_score < 3) ? 'badge badge-danger' : 'badge badge-success';
                                 ?>
                                 <span class="<?= $badge ?>"><?= $r->avg_score ?></span>
                              </td>
                             <td>
                            <!-- <?php
                                $status = ($r->jumlah_penilai >= $r->expected_evaluator_count) ? 'Lengkap' : 'Belum Lengkap';
                                $badge = $status === 'Lengkap' ? 'badge badge-success' : 'badge badge-warning';
                            ?>
                            <span class="<?= $badge ?>"><?= $status ?></span>
                            </td> -->
                           </tr>
                        <?php endforeach; ?>
                     </tbody> 
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>

<style>
  div.dataTables_filter {
    display: none; /* sembunyikan search global */
  }
</style>

<script>
$(document).ready(function () {
  const table = $('#rekapTable').DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    pageLength: 10,
    ordering: true,
    searching: true, // aktifkan searching agar search per kolom bisa jalan
    dom: 'lBfrtip',
    buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
  });

  $('#filterKaryawan').on('change', function () {
    const val = $(this).val();
    table.column(0).search(val).draw(); // ubah angka kalau kolom Nama bukan di posisi 0
  });
});
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

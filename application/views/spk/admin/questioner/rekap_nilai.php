<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <h3><?= $title ?></h3>
         <hr>
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
                        $names = array_unique(array_map(fn($r) => $r->employee_name, $rekap));
                        foreach ($names as $name):
                        ?>
                           <option value="<?= $name ?>"><?= $name ?></option>
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
                           <th>Nilai Rata-rata</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach ($rekap as $r): ?>
                           <tr>
                              <td><?= htmlspecialchars($r->employee_name) ?></td>
                              <td><?= htmlspecialchars($r->criteria_name) ?></td>
                              <td><?= htmlspecialchars($r->aspect_name) ?></td>
                              <td>
                                 <?= $r->penilaian_type === 'peer' ? 'Rekan Kerja' : 'Atasan' ?>
                              </td>
                              <td>
                                 <?php
                                 $badge = ($r->avg_score < 3) ? 'badge badge-danger' : 'badge badge-success';
                                 ?>
                                 <span class="<?= $badge ?>"><?= $r->avg_score ?></span>
                              </td>
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

<!-- DataTables + Filter JS -->
<script>
   $(document).ready(function () {
      const table = $("#rekapTable").DataTable({
         responsive: true,
         lengthChange: false,
         autoWidth: false,
         pageLength: 10,
         ordering: true,
         dom: 'Bfrtip',
         buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
      });

      $('#filterKaryawan').on('change', function () {
         const val = $(this).val();
         table.column(0).search(val).draw();
      });
   });
</script>

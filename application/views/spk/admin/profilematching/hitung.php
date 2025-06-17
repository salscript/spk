<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h4 class="font-weight-bold">Detail Perhitungan Bonus Karyawan</h4>
            <small>Periode Tanggal Input: <strong><?= date('d M Y', strtotime($tanggal_input)) ?></strong></small>
            <div class="mt-3">
                    <a href="<?= base_url('perhitungan/select') ?>" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                    <a href="<?= base_url('perhitungan/detail?tanggal=' . $tanggal_input) ?>" class="btn btn-info">
                        <i class="fa fa-sync-alt"></i> Reload
                    </a>
                </div>

        </div>
</section>
                                <section class="content">
                                    <div class="container-fluid">

                                    <h5 class="mt-4">1. Perhitungan GAP dan Bobot GAP per Aspek </h5>
                            <?php foreach ($hasil_gap as $aspect_id => $aspek): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white font-weight-bold">
                                        <?= $aspek['aspect_name'] ?>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered table-sm text-center align-middle">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th rowspan="2">Nama Karyawan</th>
                                                    <th colspan="<?= count($aspek['kriteria']) ?>">Nilai Aktual</th>
                                                    <th colspan="<?= count($aspek['kriteria']) ?>">Nilai Target</th>
                                                    <th colspan="<?= count($aspek['kriteria']) ?>">GAP</th>
                                                    <th colspan="<?= count($aspek['kriteria']) ?>">Bobot GAP</th>
                                                </tr>
                                                <tr>
                                                    <?php foreach ($aspek['kriteria'] as $k): ?><th><?= $k ?></th><?php endforeach; ?>
                                                    <?php foreach ($aspek['kriteria'] as $k): ?><th><?= $k ?></th><?php endforeach; ?>
                                                    <?php foreach ($aspek['kriteria'] as $k): ?><th><?= $k ?></th><?php endforeach; ?>
                                                    <?php foreach ($aspek['kriteria'] as $k): ?><th><?= $k ?></th><?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($aspek['data'] as $nama => $rows): ?>
                                                    <tr>
                                                        <td class="text-left"><?= $nama ?></td>

                                                        <!-- Nilai Aktual -->
                                                        <?php foreach ($aspek['kriteria'] as $id_k => $k_name): ?>
                                                            <td><?= isset($rows[$id_k]) ? $rows[$id_k]['actual'] : '-' ?></td>
                                                        <?php endforeach; ?>

                                                        <!-- Nilai Target -->
                                                        <?php foreach ($aspek['kriteria'] as $id_k => $k_name): ?>
                                                            <td><?= isset($aspek['target'][$id_k]) ? $aspek['target'][$id_k] : '-' ?></td>
                                                        <?php endforeach; ?>

                                                        <!-- GAP -->
                                                        <?php foreach ($aspek['kriteria'] as $id_k => $k_name): ?>
                                                            <td><?= isset($rows[$id_k]) ? $rows[$id_k]['gap'] : '-' ?></td>
                                                        <?php endforeach; ?>

                                                        <!-- Bobot GAP -->
                                                        <?php foreach ($aspek['kriteria'] as $id_k => $k_name): ?>
                                                            <td><?= isset($rows[$id_k]) ? $rows[$id_k]['bobot_gap'] : '-' ?></td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; ?>


                                <!-- 2. Perhitungan CF, SF, dan Total Nilai Aspek Berdasarkan Bobot Kriteria -->
                            <h5 class="mt-4">2. Perhitungan CF, SF, dan Total Nilai Aspek Berdasarkan Bobot Kriteria</h5>
                            <?php foreach ($cf_sf_bobot as $aspek): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white font-weight-bold">
                                        <?= $aspek['aspect_name'] ?>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered table-sm text-center">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th rowspan="2">Nama Karyawan</th>
                                                    <?php foreach ($aspek['kriteria'] as $k): ?>
                                                        <th><?= $k['name'] ?><br><small><?= ucfirst($k['type']) ?></small></th>
                                                    <?php endforeach; ?>
                                                    <th rowspan="2">CF</th>
                                                    <th rowspan="2">SF</th>
                                                    <th rowspan="2">CF Weight</th>
                                                    <th rowspan="2">SF Weight</th>
                                                    <th rowspan="2">Total Nilai Aspek</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($aspek['karyawan'] as $k): ?>
                                                    <tr>
                                                        <td class="text-left"><?= $k['fullname'] ?></td>
                                                        <?php foreach ($k['nilai_kriteria'] as $nk): ?>
                                                            <td><?= $nk['bobot_gap'] ?></td>
                                                        <?php endforeach; ?>
                                                        <td><?= $k['cf_nilai'] ?></td>
                                                        <td><?= $k['sf_nilai'] ?></td>
                                                        <td><?= $k['cf_weight'] ?></td>
                                                        <td><?= $k['sf_weight'] ?></td>
                                                        <td class="bg-success text-white font-weight-bold"><?= $k['total_aspek'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                                    <h5 class="mt-4">3. Kontribusi Aspek dan Total Nilai Akhir</h5>
                            <div class="card">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered text-center">
                                <thead class="bg-light">
                                    <tr>
                                    <th rowspan="2">Nama Karyawan</th>
                                    <?php foreach ($list_aspek as $asp): ?>
                                        <th colspan="2"><?= $asp['name'] ?> <br><small>(Bobot: <?= $asp['bobot'] ?>)</small></th>
                                    <?php endforeach; ?>
                                    <th rowspan="2" class="bg-success text-white">Total Nilai Akhir</th>
                                    </tr>
                                    <tr>
                                    <?php foreach ($list_aspek as $asp): ?>
                                        <th>Nilai Aspek</th>
                                        <th>Kontribusi</th>
                                    <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($hasil_aspek as $row): ?>
                                    <tr>
                                        <td class="text-left"><?= $row['fullname'] ?></td>
                                        <?php $total = 0; ?>
                                        <?php foreach ($list_aspek as $asp): ?>
                                        <?php
                                            // ambil nilai aspek tertentu
                                            $aspek_data = array_filter($row['aspek'], fn($a) => $a['aspect_name'] === $asp['name']);
                                            $aspek_data = array_values($aspek_data);
                                            $nilai = $aspek_data[0]['nilai_aspek'] ?? 0;
                                            $kontribusi = round($nilai * $asp['bobot'], 4);
                                            $total += $kontribusi;
                                        ?>
                                        <td><?= $nilai ?></td>
                                        <td><?= $kontribusi ?></td>
                                        <?php endforeach; ?>
                                        <td class="bg-success text-white"><strong><?= round($total, 4) ?></strong></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                            </div>
                            </div>

                                        </table>

                                        <!-- 4. Ranking -->
                                        <h5 class="mt-4">4. Ranking Karyawan</h5>
                                        <table class="table table-bordered text-center">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>Nama Karyawan</th>
                                                    <th>Nilai Akhir</th>
                                                    <th>Ranking</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($hasil_aspek as $row): ?>
                                                    <tr>
                                                        <td><?= $row['fullname'] ?></td>
                                                        <td><?= $row['total_nilai'] ?></td>
                                                        <td><?= $row['ranking'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                                </div>
                                                <?php if (!$is_hasil_sudah_disimpan): ?>
                                                    <form method="post" action="<?= base_url('perhitungan/simpan_hasil') ?>">
                                                        <input type="hidden" name="tanggal_input" value="<?= $tanggal_input ?>">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fa fa-save"></i> Simpan Hasil Perhitungan
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <div class="alert alert-secondary text-center mt-3">
                                                        <i class="fa fa-check-circle text-success"></i> Hasil perhitungan untuk tanggal ini sudah disimpan.
                                                    </div>
                                                <?php endif; ?>
                                    </div>
                                </section>
                            </div>
                            <script>
    function back() {
        window.history.back();
    }

    function reload() {
        location.reload();
    }
</script>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h4 class="font-weight-bold">Pilih Tanggal Perhitungan Bonus</h4>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-outline card-primary">
                <div class="card-body">
                    <form method="GET" action="<?= base_url('perhitungan/hasil') ?>">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label font-weight-bold">Pilih Tanggal Perhitungan</label>
                            <div class="col-sm-6">
                                <select name="tanggal" id="tanggal" class="form-control" required>
                                    <option value="">-- Pilih Tanggal --</option>
                                    <?php foreach ($tanggal_list as $tgl): ?>
                                        <option value="<?= $tgl->tanggal_input ?>" <?= ($tanggal == $tgl->tanggal_input) ? 'selected' : '' ?>>
                                            <?= date('d M Y', strtotime($tgl->tanggal_input)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i> Lihat Hasil Perhitungan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (!empty($hasil)): ?>
                <div class="card card-outline card-success mt-4">
                    <div class="card-header bg-success text-white">
                        Hasil Perhitungan - <?= date('d M Y', strtotime($tanggal)) ?>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Nilai Akhir</th>
                                    <th>Ranking</th>
                                    <th>Persentase Bonus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($hasil as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td class="text-left"><?= $row->fullname ?></td>
                                        <td><?= $row->nilai_akhir ?></td>
                                        <td><?= $row->ranking ?></td>
                                        <td><strong><?= $row->persentase_bonus ?>%</strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="text-right mt-3">
                            <a href="<?= base_url('perhitungan/laporan_hasil?tanggal=' . $tanggal) ?>" target="_blank" class="btn btn-outline-primary">
                                <i class="fa fa-print"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>
                </div>
            <?php elseif (!empty($tanggal)): ?>
                <div class="alert alert-warning mt-4 text-center">
                    <i class="fa fa-exclamation-circle"></i> Tidak ada data hasil perhitungan untuk tanggal ini.
                </div>
            <?php endif; ?>

        </div>
    </section>
</div>

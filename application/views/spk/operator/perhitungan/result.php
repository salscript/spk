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
                    <form method="GET" action="<?= base_url('perhitungan/laporan_hasil') ?>">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pilih Periode Tanggal Perhitungan</label>
                            <div class="col-sm-5">
                                <select name="tanggal" class="form-control" required>
                                    <option value="">-- Pilih Tanggal --</option>
                                    <?php foreach ($tanggal_list as $t): ?>
                                        <option value="<?= $t->tanggal ?>">
                                            <?= date('d M Y', strtotime($t->tanggal)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-eye"></i> Lihat Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>

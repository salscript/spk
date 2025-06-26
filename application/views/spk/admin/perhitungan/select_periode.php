<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid mb-2">
            <h3 class="font-weight-bold">Pilih Periode Perhitungan Bonus</h3>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-outline card-primary">
                <div class="card-body">
                    <form method="get" action="<?= base_url('perhitungan/detail') ?>">
                        <div class="form-group">
                            <label for="tanggal">Pilih Tanggal Input Nilai Aktual</label>
                            <select name="tanggal" id="tanggal" class="form-control" required onchange="cekStatus(this.value)">
                                <option value="">-- Pilih Tanggal --</option>
                                <?php foreach ($periodes as $p): ?>
                                    <option value="<?= $p->tanggal_input ?>">
                                        <?= date('d M Y', strtotime($p->tanggal_input)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fa fa-search"></i> Lihat Hasil Perhitungan
                        </button>
                    </form>

                    <div id="infoStatus" class="mt-3"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const statusPeriode = <?= json_encode(array_map(function($p) {
        return [
            'tanggal' => $p->tanggal_input,
            'status'  => $p->sudah_dihitung
        ];
    }, $periodes)) ?>;

    function cekStatus(tanggal) {
        document.getElementById('hiddenTanggal').value = tanggal;

        const btn = document.getElementById('btnSimpan');
        const info = document.getElementById('infoStatus');

        const item = statusPeriode.find(p => p.tanggal === tanggal);
        if (item && item.status == 1) {
            btn.disabled = true;
            info.innerHTML = `<span class="badge badge-success">Hasil sudah disimpan untuk tanggal ini</span>`;
        } else {
            btn.disabled = false;
            info.innerHTML = `<span class="badge badge-warning">Hasil belum disimpan</span>`;
        }
    }
</script>

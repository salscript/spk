<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid mb-2">
            <h3 class="font-weight-bold">Perhitungan Profile Matching</h3>
            <small>Pilih periode penilaian untuk melihat perhitungan lengkap</small>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Penilaian</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($questioners as $q): ?>
                                <tr class="text-center">
                                    <td><?= $no++ ?></td>
                                    <td><?= $q->code_questioner ?></td>
                                    <td><?= date('d M Y', strtotime($q->created_on)) ?></td>
                                    <td>
                                        <a href="<?= base_url('perhitungan/detail/' . $q->id) ?>" class="btn btn-sm btn-primary">
                                            <i class="fa fa-search"></i> Lihat Perhitungan
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($questioners)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data penilaian.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

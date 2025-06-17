<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 mt-2">
                <div class="col-sm-6">
                    <h3 class="m-0 font-weight-bold">Daftar Periode Penilaian</h3>
                </div>
            </div>

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="text-center bg-light">
                                <th>No</th>
                                <th>Kode Penilaian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($questioners as $q) : ?>
                                <tr class="text-center">
                                    <td><?= $no++; ?></td>
                                    <td><?= $q->code_questioner; ?></td>
                                    <td>
                                        <?php if (!empty($q->sudah_diisi_semua_aspek)) : ?>
                                            <button class="btn btn-sm btn-secondary" disabled title="Nilai semua aspek sudah diinput">
                                                <i class="fa fa-check"></i> Sudah Lengkap
                                            </button>
                                        <?php else: ?>
                                            <a href="<?= base_url('penilaian/input/' . $q->id); ?>" class="btn btn-sm btn-primary">
                                                <i class="fa fa-edit"></i> Input Nilai Aktual
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($questioners)) : ?>
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data penilaian.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kuisioner yang Belum Lengkap</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Karyawan</th>
                                    <th>Jabatan</th>
                                    <th>Divisi</th>
                                    <th>Sudah Dinilai</th>
                                    <th>Total Harus Dinilai</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($incomplete_questioners as $q): ?>
                                <tr>
                                    <td><?= $q->fullname ?></td>
                                    <td><?= $q->position ?></td>
                                    <td><?= $q->division ?></td>
                                    <td><?= $q->completed_count ?></td>
                                    <td><?= $q->total_count ?></td>
                                    <td>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-<?= ($q->completed_count/$q->total_count*100 >= 50) ? 'success' : 'danger' ?>" 
                                                 style="width: <?= ($q->completed_count/$q->total_count*100) ?>%"></div>
                                        </div>
                                        <span class="badge bg-<?= ($q->completed_count/$q->total_count*100 >= 50) ? 'green' : 'red' ?>">
                                            <?= round($q->completed_count/$q->total_count*100, 2) ?>%
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Semua Kuisioner</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="questionerTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Penilai</th>
                                    <th>Jabatan</th>
                                    <th>Divisi</th>
                                    <th>Dinilai</th>
                                    <th>Jabatan</th>
                                    <th>Divisi</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_questioners as $q): ?>
                                <tr>
                                    <td><?= $q->evaluator_name ?></td>
                                    <td><?= $q->evaluator_position ?></td>
                                    <td><?= $q->evaluator_division ?></td>
                                    <td><?= $q->evaluatee_name ?></td>
                                    <td><?= $q->evaluatee_position ?></td>
                                    <td><?= $q->evaluatee_division ?></td>
                                    <td><?= ($q->type == 'peer') ? 'Rekan Kerja' : 'Atasan' ?></td>
                                    <td>
                                        <span class="label label-<?= ($q->status == 'completed') ? 'success' : 'warning' ?>">
                                            <?= ($q->status == 'completed') ? 'Selesai' : 'Pending' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($q->created_at)) ?></td>
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

<script>
    $(function () {
        $('#questionerTable').DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": [[8, "desc"]]
        });
    });
</script>
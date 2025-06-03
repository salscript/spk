<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('user') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-check"></i> <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa fa-ban"></i> <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_peer" data-toggle="tab">Kuisioner Rekan Kerja</a></li>
                        <?php if ($is_pic || $is_hrd): ?>
                            <li><a href="#tab_supervisor" data-toggle="tab">Kuisioner Atasan</a></li>
                        <?php endif; ?>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_peer">
                            <div class="box">
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>Divisi</th>
                                                <th>Status</th>
                                                <th>Waktu Penilaian</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($peer_questioners as $peer): ?>
                                            <tr class="<?= ($peer->status == 'completed') ? 'success' : 'warning' ?>">
                                                <td><?= $peer->fullname ?></td>
                                                <td><?= $peer->position_name ?></td>
                                                <td><?= $peer->division_name ?></td>
                                                <td>
                                                    <?php if ($peer->status == 'completed'): ?>
                                                        <span class="label label-success">Selesai</span>
                                                    <?php else: ?>
                                                        <span class="label label-warning">Belum Dinilai</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?= $peer->created_at ? date('d/m/Y H:i', strtotime($peer->created_at)) : '-' ?>
                                                </td>
                                                <td>
                                                    <?php if ($peer->status != 'completed'): ?>
                                                        <a href="<?= site_url('questioner/peer/'.$peer->id) ?>" class="btn btn-primary btn-xs">
                                                            <i class="fa fa-edit"></i> Nilai
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="badge bg-green"><i class="fa fa-check"></i> Selesai</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <?php if ($is_pic || $is_hrd): ?>
                            <div class="tab-pane" id="tab_supervisor">
                                <div class="box">
                                    <div class="box-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Divisi</th>
                                                    <th>Status</th>
                                                    <th>Waktu Penilaian</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($supervisor_questioners as $supervisor): ?>
                                                <tr class="<?= ($supervisor->status == 'completed') ? 'success' : 'warning' ?>">
                                                    <td><?= $supervisor->fullname ?></td>
                                                    <td><?= $supervisor->position_name ?></td>
                                                    <td><?= $supervisor->division_name ?></td>
                                                    <td>
                                                        <?php if ($supervisor->status == 'completed'): ?>
                                                            <span class="label label-success">Selesai</span>
                                                        <?php else: ?>
                                                            <span class="label label-warning">Belum Dinilai</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?= $supervisor->created_at ? date('d/m/Y H:i', strtotime($supervisor->created_at)) : '-' ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($supervisor->status != 'completed'): ?>
                                                            <a href="<?= site_url('questioner/supervisor/'.$supervisor->id) ?>" class="btn btn-primary btn-xs">
                                                                <i class="fa fa-edit"></i> Nilai
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="badge bg-green"><i class="fa fa-check"></i> Selesai</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
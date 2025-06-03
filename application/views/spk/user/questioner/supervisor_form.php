<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('user') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= site_url('questioner') ?>">Kuisioner</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penilaian untuk: <?= $evaluatee->fullname ?></h3>
                        <div class="box-tools pull-right">
                            <span class="label label-info"><?= $evaluatee->position_name ?></span>
                            <span class="label label-primary"><?= $evaluatee->division_name ?></span>
                        </div>
                    </div>
                    <form method="post" action="<?= site_url('questioner/submit_supervisor') ?>">
                        <div class="box-body">
                            <input type="hidden" name="evaluatee_id" value="<?= $evaluatee->id ?>">
                            
                            <?php foreach ($questions as $question): ?>
                            <div class="form-group">
                                <label>
                                    <strong><?= $question->criteria_name ?></strong>: 
                                    <?= $question->name ?>
                                </label>
                                <select name="question[<?= $question->id ?>]" class="form-control" required>
                                    <option value="">-- Pilih Nilai --</option>
                                    <option value="5">Sangat Baik (5)</option>
                                    <option value="4">Baik (4)</option>
                                    <option value="3">Cukup (3)</option>
                                    <option value="2">Kurang (2)</option>
                                    <option value="1">Sangat Kurang (1)</option>
                                </select>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Simpan Penilaian
                            </button>
                            <a href="<?= site_url('questioner') ?>" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
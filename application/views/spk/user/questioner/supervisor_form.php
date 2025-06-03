<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <div class="content-wrapper p-3">
        <h3><?= $title ?> untuk <?= $evaluatee->fullname ?></h3>
        <form action="<?= site_url('questioner/submit_supervisor') ?>" method="POST">
            <input type="hidden" name="evaluatee_id" value="<?= $evaluatee->id ?>">
            <?php foreach($questions as $q): ?>
                <div class="form-group">
                    <label><?= $q->question_text ?></label>
                    <select name="answers[<?= $q->id ?>]" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="1">1 - Sangat Tidak Setuju</option>
                        <option value="2">2 - Tidak Setuju</option>
                        <option value="3">3 - Netral</option>
                        <option value="4">4 - Setuju</option>
                        <option value="5">5 - Sangat Setuju</option>
                    </select>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Kirim Penilaian</button>
            <a href="<?= site_url('questioner') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/js/adminlte.min.js') ?>"></script>
</body>
</html>

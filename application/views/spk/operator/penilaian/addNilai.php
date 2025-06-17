<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h3 class="m-0 font-weight-bold">Input Nilai Aktual Karyawan</h3>
            <small>Periode Penilaian: <strong><?= $questioner->code_questioner ?></strong></small>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <!-- Form pilih aspek -->
            <form method="post" action="<?= base_url('penilaian/input/' . $questioner_id); ?>">
                <div class="form-group row">
                    <label for="aspect_id" class="col-sm-2 col-form-label">Pilih Aspek Penilaian</label>
                    <div class="col-sm-6">
                        <select name="aspect_id" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Pilih Aspek --</option>
                            <?php foreach ($aspek as $asp) : ?>
                                <option value="<?= $asp->id ?>" <?= isset($selected_aspect) && $selected_aspect == $asp->id ? 'selected' : '' ?>>
                                    <?= $asp->name ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
<?php if (isset($criteria) && isset($employees)) : ?>

    <?php if (isset($is_aspek_sudah_isi) && $is_aspek_sudah_isi): ?>
        <div class="alert alert-success">
            Nilai untuk aspek <strong><?= $selected_aspect_name ?? '' ?></strong> sudah disimpan. Anda tidak dapat mengubahnya kembali dari sini.
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('penilaian/simpan'); ?>">
        <input type="hidden" name="questioner_id" value="<?= $questioner_id ?>">

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <?php foreach ($criteria as $c) : ?>
                            <th><?= $c->name ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($employees as $emp) : ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $emp->fullname ?></td>
                            <?php foreach ($criteria as $c) : ?>
                                <td>
                                    <select class="form-control" name="employee_id[<?= $emp->id ?>][<?= $c->id ?>]" <?= ($is_aspek_sudah_isi ? 'disabled' : '') ?> required>
                                        <option value="">- Pilih -</option>
                                        <?php foreach ($subkriteria[$c->id] as $sub) : ?>
                                            <option value="<?= $sub->id ?>" <?= isset($auto_subkriteria[$emp->id][$c->id]) && $auto_subkriteria[$emp->id][$c->id] == $sub->id ? 'selected' : '' ?>>
                                                <?= $sub->name ?> (<?= $sub->value ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3 text-right">
            <?php if ($is_aspek_sudah_isi): ?>
                <button class="btn btn-secondary" disabled>Nilai aspek ini sudah disimpan</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan Nilai Aktual
                </button>
            <?php endif; ?>
        </div>
    </form>
<?php endif; ?>

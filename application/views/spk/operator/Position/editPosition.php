<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 mt-3">
                <div class="col-sm-6">
                    <h3 class="m-0 font-weight-bolder">Edit Position</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <?= form_open('position/update_position', ['class' => 'formEditPosition']) ?>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal">Position Details</h5>
                            <p class="font-weight-normal text-black-50 text-sm">This information will be displayed publicly.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <input type="hidden" name="id" id="id" class="form-control" value="<?= $position->id ?>">

                            <div class="form-group">
                                <label for="position" class="font-weight-normal">Nama Position</label>
                                <input type="text" name="position" id="position" class="form-control text-dark font-weight-normal text-sm" value="<?= $position->name ?>" placeholder="Position Name" required>
                            </div>

                            <div class="form-group">
                                <label for="level_position" class="font-weight-normal">Level Position</label>
                                <select name="level_position" id="level_position" class="form-control text-dark font-weight-normal text-sm" required>
                                    <option value="">-- Pilih Level --</option>
                                    <option value="staff" <?= $position->level_position == 'staff' ? 'selected' : '' ?>>Staff</option>
                                    <option value="senior_staff" <?= $position->level_position == 'senior_staff' ? 'selected' : '' ?>>Senior Staff</option>
                                    <option value="managerial" <?= $position->level_position == 'managerial' ? 'selected' : '' ?>>Managerial</option>
                                    <option value="hrd" <?= $position->level_position == 'hrd' ? 'selected' : '' ?>>HRD</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button type="reset" onclick="back()" class="btn btn-danger text-sm">Cancel</button>
                        <button type="submit" class="btn btn-primary text-sm">Update</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.formEditPosition').submit(function(e) {
            e.preventDefault();

            const $id = $('#id').val();
            const $position = $('#position').val();
            const $level_position = $('#level_position').val();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    id: $id,
                    position: $position,
                    level_position: $level_position
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        toastr.error(response.error);
                    }
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        setTimeout(function() {
                            window.location.href = "<?= base_url('position/position') ?>";
                        }, 1000);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });

    function back() {
        window.location.href = "<?= base_url('position/position') ?>";
    }
</script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 mt-3">
                <div class="col-sm-6">
                    <h3 class="m-0 font-weight-bolder">Edit User</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <?php echo form_open('user/update_user', ['class' => 'formEditUser']) ?>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal">User Details</h5>
                            <p class="font-weight-normal text-black-50 text-sm">This information will be displayed publicly.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <input type="hidden" name="id_user" id="id_user" value="<?= $user->id ?>">
                            <div class="form-group">
                                <label for="code_user" class="font-weight-normal">Code User</label>
                                <input type="text" name="code_user" id="code_user" readonly class="form-control text-dark font-weight-normal text-sm" value="<?= $user->code_user ?>">
                            </div>
                            <div class="form-group">
                                <label for="fullname" class="font-weight-normal">Full Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control text-dark font-weight-normal text-sm" value="<?= htmlspecialchars($user->fullname) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-weight-normal">Email</label>
                                <input type="email" name="email" id="email" readonly class="form-control text-dark font-weight-normal text-sm" value="<?= htmlspecialchars($user->email) ?>">
                            </div>
                            <div class="form-group">
                                <label for="password" class="font-weight-normal">Password</label>
                                <input type="password" name="password" id="password" class="form-control text-dark font-weight-normal text-sm" placeholder="Leave blank to keep current password">
                            </div>
                            <div class="form-group">
                                <label for="position" class="font-weight-normal">Position</label>
                                <select name="position" id="position" class="form-control text-dark font-weight-normal text-sm" required>
                                    <?php foreach ($position as $row): ?>
                                        <option value="<?= $row->id ?>" <?= $row->id == $user->position_id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="division" class="font-weight-normal">Division</label>
                                <select name="division[]" id="division" class="form-control select2 font-weight-normal text-sm" multiple="multiple" required>
                                    <?php foreach ($division as $row): ?>
                                        <option value="<?= $row->id ?>" <?= in_array($row->id, $user_division_ids) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subdivisi" class="font-weight-normal">Sub Divisi</label>
                                <input type="text" name="sub_divisi" id="subdivisi" class="form-control text-dark font-weight-normal text-sm" placeholder="Subdivisi" value="<?= htmlspecialchars($user->subdivisi ?? '') ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address" class="font-weight-normal">Alamat</label>
                                <input type="text" name="address" id="address" class="form-control text-dark font-weight-normal text-sm" value="<?= htmlspecialchars($user->alamat) ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nomortelepon" class="font-weight-normal">Nomor Telepon</label>
                                <input type="tel" name="nomortelepon" id="nomortelepon" pattern="\d+" class="form-control text-dark font-weight-normal text-sm" value="<?= htmlspecialchars($user->nomortelepon) ?>" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal">User Settings</h5>
                            <p class="font-weight-normal text-black-50 text-sm">User settings and permissions access.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <div class="form-group">
                                <label for="role" class="font-weight-normal">Role</label>
                                <select name="role" id="role" class="form-control text-dark font-weight-normal text-sm" required>
                                    <?php foreach ($role as $row): ?>
                                        <option value="<?= $row->id ?>" <?= $row->id == $user->role_id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($row->name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <?php $statusChecked = $user->status == 1 ? 'checked' : ''; ?>
                                <label for="status" class="font-weight-normal">Status</label><br>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="status" class="custom-control-input" id="customSwitch1" <?= $statusChecked ?>>
                                    <label class="custom-control-label" for="customSwitch1">
                                        <span class="text-xs font-weight-normal text-black-50">
                                            The user is <?= $user->status == 1 ? 'active' : 'inactive' ?>
                                        </span>
                                    </label>
                                </div>
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
                <?php echo form_close() ?>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Division",
            allowClear: true
        });

        $('.formEditUser').submit(function(e) {
            e.preventDefault();

            const password = $('#password').val().trim();
            const sub_divisi = $('#subdivisi').val().trim();

            // Validasi Sub Divisi wajib
            if (sub_divisi === '') {
                toastr.error('The Sub Divisi field is required.');
                $('#subdivisi').focus();
                return false;
            }

            // Ambil data form
            const data = {
                id_user: $('#id_user').val(),
                fullname: $('#fullname').val(),
                password: password,
                sub_divisi: sub_divisi, // pastikan nama key sesuai input name
                position: $('#position').val(),
                division: $('#division').val(), // array dari select2 multiple
                address: $('#address').val(),
                nomortelepon: $('#nomortelepon').val(),
                role: $('#role').val(),
                status: $('#customSwitch1').is(':checked') ? 1 : 0,
            };

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        toastr.error(response.error);
                    } else if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "<?= base_url('user/user') ?>";
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });

    function back() {
        window.location.href = "<?= base_url('user/user') ?>";
    }
</script>

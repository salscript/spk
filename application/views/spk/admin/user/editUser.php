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
                            <h5 class="font-weight-normal"> User Details</h5>
                            <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <div class="form-group">
                                <label for="code_user" class="font-weight-normal">Code User</label>
                                <input type="text" name="code_user" value="<?= $user['id'] ?>" class="form-control">
                                <input type="text" name="code_user" id="code_user" readonly class="form-control text-dark font-weight-normal text-sm" value="<?= $user->code_user ?>">
                            </div>
                            <div class="form-group">
                                <label for="fullname" class="font-weight-normal">Full Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control text-dark font-weight-normal text-sm" value="<?= $user->fullname ?>">
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-weight-normal">Email</label>
                                <input type="text" name="email" id="email" readonly class="form-control text-dark font-weight-normal text-sm" value="<?= $user->email ?>">
                            </div>
                            <div class="form-group">
                                <label for="password" class="font-weight-normal">Password</label>
                                <input type="text" name="password" id="password" class="form-control text-dark font-weight-normal text-sm" value="<?= $user->password ?>">
                            </div>
                            <div class="form-group">
                                <label for="position" class="font-weight-normal">Position</label>
                                <select name="position" id="position" class="form-control text-dark font-weight-normal text-sm">
                                    <option value="" disabled>Select an option</option>
                                    <?php
                                    foreach ($position as $row) { ?>
                                        <option value="<?= $row->id ?>" <?= $row->id == $user->position_id ? "selected" : null ?>>
                                            <?= $row->name ?>
                                        </option>
                                    <?php }
                                    ?> 
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="division" class="font-weight-normal">Division</label>
                                <select name="division" id="division" class="form-control text-dark font-weight-normal text-sm">
                                     <option value="" disabled>Select an option</option>
                                    <?php
                                    foreach ($division as $row) { ?>
                                        <option value="<?= $row->id ?>" <?= $row->id == $user->division_id ? "selected" : null ?>>
                                            <?= $row->name ?>
                                        </option>
                                    <?php }
                                    ?> 
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address" class="font-weight-normal">Alamat</label>
                                <input type="text" name="address" id="address" class="form-control text-dark font-weight-normal text-sm" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label for="nomortelepon" class="font-weight-normal">Nomor Telepon</label>
                                <input type="text" name="nomortelepon" id="nomortelepon" class="form-control text-dark font-weight-normal text-sm" placeholder="Nomor Telepon">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal"> User Settings</h5>
                            <p class="font-weight-normal text-black-50  text-sm"> User settings and permissions access.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <div class="form-group">
                                <label for="role" class="font-weight-normal">Role</label>
                                <select name="role" id="role" class="form-control text-dark font-weight-normal text-sm">
                                    <option value="" disabled>Select an option</option>
                                    <?php
                                    foreach ($role as $row) { ?>
                                        <option value="<?= $row->id ?>" <?= $row->id == $user->role_id ? "selected" : null ?>>
                                            <?= $row->name ?>
                                        </option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <?php $status = ($user->status == 1) ? "checked" : "unchecked"; ?>
                                <?php if ($user->status == 1) {
                                    $desc = "actived";
                                } else {
                                    $desc = "deactived";
                                } ?>
                                <label for="status" class="font-weight-normal">Status</label><br>
                                <div class="custom-control custom-switch">
                                    <!-- <input type="checkbox" name="my-checkbox" id="status" data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" <?php echo $status ?>>
                                    <label class="custom-control-label" for="customSwitch1">
                                        <span class="text-xs font-weight-normal text-black-50">The user is <?= $desc ?></span>
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
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state');
        });
        // bsCustomFileInput.init();

        $('.formEditUser').submit(function(e) {
            $id_user = $('#id').val();
            $code_user = $('#code').val();
            $fullname = $('#fullname').val();
            $email = $('#email').val();
            $password = $('#password').val();
            $company = $('#company').val();
            $divisi = $('#divisi').val();
            $role = $('#role').val();
            $status = getStatusChanged('#customSwitch1');

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                // data: $(this).serialize(),
                data: {
                    id_user: $id_user,
                    code_user: $code_user,
                    fullname: $fullname,
                    email: $email,
                    password: $password,
                    company: $company,
                    divisi: $divisi,
                    role: $role,
                    status: $status
                },
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        // $('.pesan').html(response.error).show();
                        toastr.error(response.error);
                    }
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                        setTimeout(function() {
                            window.location.href = "<?= base_url('user/user') ?>"
                            // location.reload();
                        }, 1000)
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        });

    })

    function getStatusChanged(obj) {
        var status = 0;
        if ($(obj).is(":checked")) {
            status = 1;
        }
        return status;
    }

    function back() {
        window.location.href = "<?= base_url('user/user') ?>"
    }
</script>
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
                                <input type="hidden" name="id_user" id="id_user" value="<?= $user->id ?>" class="form-control">
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
                                <select name="division[]" multiple="multiple" id="division" class="form-control select2 font-weight-normal text-sm">
                                    <?php
                                    foreach ($division as $row) { ?>
                                        <option value="<?= $row->id ?>" <?= in_array($row->id, $user_division_ids) ? "selected" : "" ?>>
                                            <?= $row->name ?>
                                        </option>
                                    <?php }
                                    ?> 
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address" class="font-weight-normal">Alamat</label>
                                <input type="text" name="address" id="address" class="form-control text-dark font-weight-normal text-sm" value="<?= $user->alamat ?>">
                            </div>
                            <div class="form-group">
                                <label for="nomortelepon" class="font-weight-normal">Nomor Telepon</label>
                                <input type="text" name="nomortelepon" id="nomortelepon" pattern="\d+" class="form-control text-dark font-weight-normal text-sm" value="<?= $user->nomortelepon ?>">
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
                                <?php $status = ($user->status == 1) ? "checked" : ""; ?>
                                <?php if ($user->status == 1) {
                                    $desc = "actived";
                                } else {
                                    $desc = "deactived";
                                } ?>
                                <label for="status" class="font-weight-normal">Status</label><br>
                                <div class="custom-control custom-switch">
                                    <!-- <input type="checkbox" name="my-checkbox" id="status" data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
                                    <input type="checkbox" name="status" class="custom-control-input" id="customSwitch1" <?php echo $status ?>>
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
        $('.select2').select2();

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state');
        });
        // bsCustomFileInput.init();

        $('.formEditUser').submit(function(e) {
            $id_user = $('#id_user').val();
            $fullname = $('#fullname').val();
            $password = $('#password').val();
            $position = $('#position').val();
            $role = $('#role').val();
            $address = $('#address').val();
            $nomortelepon = $('#nomortelepon').val();
            $status = getStatusChanged('#customSwitch1');
            $division = $("#division option:selected").map(function() {
                return $(this).val();
            }).get();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    id_user: $id_user,
                    fullname: $fullname,
                    password: $password,
                    position: $position,
                    division: $division,
                    address: $address,
                    nomortelepon: $nomortelepon,
                    role: $role,
                    status: $status
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
                        })
                        setTimeout(function() {
                            window.location.href = "<?= base_url('user/user') ?>"
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
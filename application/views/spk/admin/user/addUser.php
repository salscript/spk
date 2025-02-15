<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 mt-3">
                <div class="col-sm-6">
                    <h3 class="m-0 font-weight-bolder">Create User</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <?php echo form_open('user/save_user', ['class' => 'formSimpanUser']) ?>
                <!-- <form action="<?= base_url('helpdesk/user/save_user') ?>" method="post"> -->
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal"> User Details</h5>
                            <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <div class="form-group">
                                <label for="code_user" class="font-weight-normal">Code User</label>
                                <input type="text" name="code_user" id="code_user" value="<?= $code_user ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fullname" class="font-weight-normal">Full Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control text-dark font-weight-normal text-sm" placeholder="Full Name">
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-weight-normal">Email</label>
                                <input type="text" name="email" id="email" class="form-control text-dark font-weight-normal text-sm" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="password" class="font-weight-normal">Password</label>
                                <input type="text" name="password" id="password" class="form-control text-dark font-weight-normal text-sm" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="position" class="font-weight-normal">Position</label>
                                <select name="position" id="position" class="form-control text-dark font-weight-normal text-sm">
                                    <!-- <option value="" selected disabled>Select an option</option>
                                    <?php
                                    foreach ($position as $row) :
                                        echo "<option value='$row->id_position'>$row->name" . "</option>";
                                    endforeach;
                                    ?> -->
                                </select>
                            </div>
                            <div class="form-group" id="form_division">
                                <label for="division" class="font-weight-normal">Division</label>
                                <select name="division" id="division" class="form-control text-dark font-weight-normal text-sm">
                                    <!-- <option value="" selected disabled>Select an option</option>
                                    <?php
                                    foreach ($division as $row) :
                                        echo "<option value='$row->id_division'>$row->name" . "</option>";
                                    endforeach;
                                    ?> -->
                                </select>
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
                                    <option value="" selected disabled>Select an option</option>
                                    <?php
                                    foreach ($role as $row) :
                                        echo "<option value='$row->id'>$row->name" . "</option>";
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button type="reset" onclick="back()" class="btn btn-danger text-sm">Cancel</button>
                        <button type="submit" class="btn btn-primary text-sm">Save</button>
                    </div>
                </div>
                <!-- </form> -->
                <?php echo form_close() ?>
            </div>
        </div>

    </section>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#fullname').focus();
        // $('#form_divisi').hide();

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state');
        });

        $('.formSimpanUser').submit(function(e) {
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
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

    function back() {
        window.location.href = "<?= base_url('user/user') ?>"
    }
</script>
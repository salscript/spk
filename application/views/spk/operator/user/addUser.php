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
                <?php echo form_open('user/save_user', ['class' => 'formSimpanUser']); ?>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal">User Details</h5>
                            <p class="text-black-50 text-sm">This information will be displayed publicly.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <div class="form-group">
                                <label for="code_user" class="font-weight-normal">Code User</label>
                                <input type="text" name="code_user" id="code_user" value="<?= $code_user ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="fullname" class="font-weight-normal">Full Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control text-dark" placeholder="Full Name" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="font-weight-normal">Email</label>
                                <input type="email" name="email" id="email" class="form-control text-dark" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="font-weight-normal">Password</label>
                                <input type="password" name="password" id="password" class="form-control text-dark" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="position" class="font-weight-normal">Position</label>
                                <select name="position" id="position" class="form-control text-dark" required>
                                    <option value="" selected disabled>Select an option</option>
                                    <?php foreach ($position as $pos) : ?>
                                        <option value="<?= $pos->id ?>"><?= $pos->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="division" class="font-weight-normal">Division</label>
                                <select name="division[]" id="division" class="form-control select2 text-dark" multiple="multiple" required>
                                    <?php foreach ($division as $div) : ?>
                                        <option value="<?= $div->id ?>"><?= $div->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                 <label for="level_position" class="font-weight-normal">Sub Divisi</label>
                                <select name="level_position" id="level_position" class="form-control text-dark font-weight-normal text-sm" required>
                                    <option value="">-- Pilih Level --</option>
                                    <option value="staff">Umum</option>
                                    <option value="senior_staff">Layanan</option>
                                    <option value="managerial">KItchen</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address" class="font-weight-normal">Alamat</label>
                                <input type="text" name="address" id="address" class="form-control text-dark" placeholder="Address">
                            </div>
                            <div class="form-group">
                                <label for="nomortelepon" class="font-weight-normal">Nomor Telepon</label>
                                <input type="tel" name="nomortelepon" id="nomortelepon" class="form-control text-dark" placeholder="Nomor Telepon">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal">User Settings</h5>
                            <p class="text-black-50 text-sm">User settings and permissions access.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <div class="form-group">
                                <label for="role" class="font-weight-normal">Role</label>
                                <select name="role" id="role" class="form-control text-dark" required>
                                    <option value="" selected disabled>Select an option</option>
                                    <?php foreach ($role as $r) : ?>
                                        <option value="<?= $r->id ?>"><?= $r->name ?></option>
                                    <?php endforeach; ?>
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
                <?php echo form_close(); ?>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2 for multiple division selection
        $('.select2').select2({
            placeholder: "Pilih Divisi",
            allowClear: true
        });

        // Auto focus on fullname field when page loads
        $('#fullname').focus();

        // Submit form with AJAX
        $('.formSimpanUser').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        toastr.error(response.error);
                    }
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            window.location.href = "<?= base_url('user/user') ?>";
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    alert(`Error: ${xhr.status}\n${xhr.responseText}\n${error}`);
                }
            });
        });
    });

    function back() {
        window.location.href = "<?= base_url('user/user') ?>";
    }
</script>

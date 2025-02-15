<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 mt-3">
                <div class="col-sm-6">
                    <h3 class="m-0 font-weight-bolder">Account Settings</h3>
                </div>
                <div class="col-sm-6">
                    <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol> -->
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <form class="form-horizontal" class="updateAccount" id="updateAccount" role="form" method="post" action="#" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <h5 class="font-weight-normal"> Personal Information </h5>
                                        <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly so be careful what you share.</p>
                                    </div>
                                    <div class="col-8 text-dark text-sm">
                                        <div class="form-group">
                                            <label for="fullname" class="font-weight-normal">Full Name</label>
                                            <input type="text" name="fullname" id="fullname" value="<?= $this->session->fullname ?>" class="form-control">
                                            <input type="hidden" readonly name="user_id" value="<?= $this->session->id_user ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="font-weight-normal">Email</label>
                                            <input type="text" readonly name="email" id="email" value="<?= $this->session->email ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="img_ticket" class="font-weight-normal">Avatar</label>
                                            <div class="user-menu">
                                                <!-- <img id="current-avatar" src="<?php echo base_url('assets/back/' . $this->session->avatar); ?>" class="user-image img-circle img-size-50" alt="User Image"> -->
                                                <!-- <div class="d-none d-md-inline mb-5">
                                                    <input type="file" id="avatarInput" class="d-none" name="avatar" accept="image/*">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm text-sm" onclick="document.getElementById('avatarInput').click()">Change</button>
                                                </div> -->
                                                <div class="avatar-wrapper">
                                                    <img id="current-avatar" src="<?php echo base_url('assets/back/' . $this->session->avatar); ?>" class="user-image img-circle img-size-50" alt="User Image">
                                                </div>
                                                <div class="ml-3">
                                                    <input type="file" id="avatarInput" class="d-none" name="avatar" accept="image/*">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm text-sm" onclick="document.getElementById('avatarInput').click()">Change</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary text-sm float-sm-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <form class="form-horizontal" class="changePassword" id="changePassword" role="form" method="post" action="#" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <h5 class="font-weight-normal"> Change Password </h5>
                                        <p class="font-weight-normal text-black-50  text-sm"> Change your password for a new one, valid for the next login.</p>
                                    </div>
                                    <div class="col-8 text-dark text-sm">
                                        <div class="form-group">
                                            <label for="current_pass" class="font-weight-normal">Current Password</label>
                                            <input type="password" name="current_pass" id="current_pass" class="form-control text-sm" placeholder="Your current password">
                                            <input type="hidden" readonly name="user_id" value="<?= $this->session->id_user ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="new_pass" class="font-weight-normal">New Password</label>
                                            <input type="password" name="new_pass" id="new_pass" class="form-control text-sm" placeholder="Your new password">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_pass" class="font-weight-normal">Confirm New Password</label>
                                            <input type="password" name="confirm_pass" id="confirm_pass" class="form-control text-sm" placeholder="Confirm your new password">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary text-sm float-sm-right">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('avatarInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('current-avatar').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });

    $('#updateAccount').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: '<?php echo base_url('helpdesk/user/update_account'); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log("Success response", response);
                if (response.error) {
                    toastr.error(response.error);
                }
                if (response.success) {
                    console.log("Showing Swal.fire");
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        window.location.href = "<?= base_url('helpdesk/user/account_admin') ?>"
                    }, 1000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error response", xhr.status, xhr.responseText, thrownError);
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });

    $('#changePassword').on('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: '<?php echo base_url('helpdesk/user/change_password'); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log("Success response", response);
                if (response.error) {
                    toastr.error(response.error);
                }
                if (response.success) {
                    console.log("Showing Swal.fire");
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        window.location.href = "<?= base_url('helpdesk/user/account_admin') ?>"
                    }, 1000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log("Error response", xhr.status, xhr.responseText, thrownError);
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
        return false;
    });
</script>
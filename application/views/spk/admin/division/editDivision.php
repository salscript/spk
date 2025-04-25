<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-3 mt-3">
                <div class="col-sm-6">
                    <h3 class="m-0 font-weight-bolder">Edit Division</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <?php echo form_open('division/update_division', ['class' => 'formEditDivision']) ?>
                <div class="card-body">
                    <div class="row mt-2">
                        <div class="col-4">
                            <h5 class="font-weight-normal"> Division Details</h5>
                            <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly.</p>
                        </div>
                        <div class="col-8 text-sm">
                            <div class="form-group">
                            <input type="hidden" name="id" id="id" class="form-control" value="<?= $division->id ?>"></div>
                            <div class="form-group">
                                <label for="name" class="font-weight-normal">Nama division</label>
                                <input type="text" name="division" id="division" class="form-control text-dark font-weight-normal text-sm" value="<?= $division->name ?>" placeholder="division Name">
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
                <!-- </form> -->
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

        $('.formEditDivision').submit(function(e) {
            $id = $('#id').val();
            $division = $('#division').val();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    id: $id,
                    division: $division
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
                            window.location.href = "<?= base_url('division/division') ?>"
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
        window.location.href = "<?= base_url('division/division') ?>"
    }
</script>
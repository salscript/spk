<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Update Criteria</h3>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <?php echo form_open('criteria/edit_criteria', ['class' => 'formEditCriteria']) ?>
            <div class="card-body">
               <div class="row mt-2">
                  <div class="col-4">
                     <h5 class="font-weight-normal"> Criteria Details</h5>
                     <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly.</p>
                  </div>
                  <div class="col-8 text-sm">
                     <div class="form-group">
                        <input type="hidden" name="criteria_id" id="criteria_id" value="<?= $datac->id ?>" class="form-control" readonly>
                        <label for="code_criteria" class="font-weight-normal">Code Criteria</label>
                        <input type="text" name="code_criteria" id="code_criteria" value="<?= $datac->code ?>" class="form-control" readonly>
                     </div>
                     <div class="form-group">
                        <label for="aspect_id" class="font-weight-normal">Nama Aspek Penilaian </label>
                        <select name="aspect_id" id="aspect_id" class="form-control text-dark font-weight-normal text-sm" required>
                           <option value="0" selected disabled>Select an option</option>
                           <?php
                           foreach ($aspect as $row) : ?>
                              <option value="<?= $row->id ?>" <?= $row->id == $datac->aspect_id ? "selected" : null ?>> <?=$row->name?></option>
                           <?php endforeach;
                           ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="criteria" class="font-weight-normal">Nama Criteria</label>
                        <input type="text" name="criteria" id="criteria" class="form-control text-dark font-weight-normal text-sm" value="<?= $datac->criteria ?>">
                     </div>
                     <div class="form-group">
                        <label for="persentase" class="font-weight-normal">Presentase</label>
                        <input type="number" name="persentase" id="persentase" step="0.01"  min="0" max="9.99" class="form-control text-dark font-weight-normal text-sm" value="<?= $datac->persentase ?>">
                     </div>
                     <div class="form-group">
                        <label for="target" class="font-weight-normal">Target </label>
                        <input type="number" name="target" id="target" class="form-control text-dark font-weight-normal text-sm" value="<?= $datac->target ?>">
                     </div>
                     <div class="form-group">
                        <label for="factor_id" class="font-weight-normal"> Type Factor </label>
                        <select name="factor_id" id="factor_id" class="form-control text-dark font-weight-normal text-sm" required>
                           <option value="0" selected disabled>Select an option</option>
                           <?php
                           foreach ($factor as $row) :?>
                              <option value="<?= $row->id ?>" <?= $row->id == $datac->factor_id ? "selected" : null ?>> <?=$row->name?></option>
                           <?php endforeach;
                           ?>
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
            <!-- </form> -->
            <?php echo form_close() ?>
         </div>
      </div>

   </section>
</div>

<script type="text/javascript">
   $(document).ready(function() {
      $('#criteria').focus();

      $("input[data-bootstrap-switch]").each(function() {
         $(this).bootstrapSwitch('state');
      });

      $('.formEditCriteria').submit(function(e) {
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
                     window.location.href = "<?= base_url('criteria/criteria') ?>"
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

   function back() {
      window.location.href = "<?= base_url('criteria/criteria') ?>"
   }
</script>
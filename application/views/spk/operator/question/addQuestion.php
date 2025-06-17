<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Create Question</h3>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <?php echo form_open('question/save_question', ['class' => 'formSimpanQuestion']) ?>
            <div class="card-body">
               <div class="row mt-2">
                  <div class="col-4">
                     <h5 class="font-weight-normal"> Question Details</h5>
                     <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly.</p>
                  </div>
                  <div class="col-8 text-sm">
                     <div class="form-group">
                        <label for="code_question" class="font-weight-normal">Code Question</label>
                        <input type="text" name="code_question" id="code_question" value="<?= $code_question ?>" class="form-control" readonly>
                     </div>
                     <div class="form-group">
                        <label for="question" class="font-weight-normal">Question</label>
                        <input type="text" name="question" id="question" class="form-control text-dark font-weight-normal text-sm" placeholder="Question">
                     </div>
                     <div class="form-group">
                        <label for="criteria" class="font-weight-normal">Criteria</label>
                        <select name="criteria" id="criteria" class="form-control text-dark font-weight-normal text-sm">
                           <option value="0" selected disabled>Select an option</option>
                           <?php
                           foreach ($criteria as $row) :
                              echo "<option value='$row->id'>$row->criteria" . "</option>";
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
      $('#question').focus();

      $("input[data-bootstrap-switch]").each(function() {
         $(this).bootstrapSwitch('state');
      });

      $('.formSimpanQuestion').submit(function(e) {
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
                     window.location.href = "<?= base_url('question/question') ?>"
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
      window.location.href = "<?= base_url('question/question') ?>"
   }
</script>
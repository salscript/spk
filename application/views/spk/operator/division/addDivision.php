<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Create Division</h3>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <?php echo form_open('division/save_division', ['class' => 'formSimpanDivision']) ?>
            <div class="card-body">
               <div class="row mt-2">
                  <div class="col-4">
                     <h5 class="font-weight-normal"> Division Details</h5>
                     <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly.</p>
                  </div>
                  <div class="col-8 text-sm">
                     
                     <div class="form-group">
                        <label for="division" class="font-weight-normal"> Name Division</label>
                        <input type="text" name="division" id="division" class="form-control text-dark font-weight-normal text-sm" placeholder="Name Division">
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
      $('#division').focus();

      $("input[data-bootstrap-switch]").each(function() {
         $(this).bootstrapSwitch('state');
      });

      $('.formSimpanDivision').submit(function(e) {
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
                     window.location.href = "<?= base_url('division/division') ?>"
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
      window.location.href = "<?= base_url('division/division') ?>"
   }
</script>
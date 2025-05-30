<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Create Aspect</h3>
            </div>
         </div>
      </div>
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <?php echo form_open('aspect/save_aspect', ['class' => 'formSimpanAspect']) ?>
            <div class="card-body">
               <div class="row mt-2">
                  <div class="col-4">
                     <h5 class="font-weight-normal"> Aspect Details</h5>
                     <p class="font-weight-normal text-black-50  text-sm"> This information will be displayed publicly.</p>
                  </div>
                  <div class="col-8 text-sm">
                     <div class="form-group">
                        <label for="code_aspect" class="font-weight-normal">Code Aspect</label>
                        <input type="text" name="code_aspect" id="code_aspect" value="<?= $code_aspect ?>" class="form-control" readonly>
                     </div>
                     <div class="form-group">
                        <label for="name" class="font-weight-normal">Name</label>
                        <input type="text" name="name" id="name" class="form-control text-dark font-weight-normal text-sm" placeholder="Aspect Name">
                     </div>
                     <div class="form-group">
                        <label for="persentase" class="font-weight-normal">Persentase</label>
                        <input type="number" name="persentase" id="persentase" step="0.01"  min="0" max="9.99" class="form-control text-dark font-weight-normal text-sm" placeholder="Persentase">
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
      $('#aspect').focus();

      $("input[data-bootstrap-switch]").each(function() {
         $(this).bootstrapSwitch('state');
      });

      $('.formSimpanAspect').submit(function(e) {
         $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
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
                  });
                  setTimeout(function() {
                     window.location.href = "<?= base_url('aspect/aspect') ?>"
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
      window.location.href = "<?= base_url('aspect/aspect') ?>"
   }
</script>
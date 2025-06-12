<div class="content-wrapper">
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-3 mt-3">
            <div class="col-sm-6">
               <h3 class="m-0 font-weight-bolder">Edit Questioner</h3>
            </div>
         </div>
      </div>
   </section>

   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <?= form_open('questioner/update_questioner', ['class' => 'formEditQuestioner']) ?>
            <div class="card-body">
               <div class="row mt-2">
                  <div class="col-4">
                     <h5 class="font-weight-normal">Questioner Details</h5>
                     <p class="font-weight-normal text-black-50 text-sm">
                        This information will be displayed publicly.
                     </p>
                  </div>
                  <div class="col-8 text-sm">
                     <input type="hidden" name="id" value="<?= $questioner->id ?>">

                     <div class="form-group">
                        <label for="code_questioner" class="font-weight-normal">Code Questioner</label>
                        <input type="text" name="code_questioner" id="code_questioner"
                               value="<?= $questioner->code_questioner ?>"
                               class="form-control" readonly>
                     </div>

                     <div class="form-group">
                        <label class="font-weight-normal">Deadline</label>
                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                           <input type="text" id="deadline" name="deadline"
                                  value="<?= date('d-m-Y H:i', strtotime($questioner->deadline)) ?>"
                                  onkeydown="return false;"
                                  class="form-control datetimepicker-input"
                                  placeholder="DD-MM-YYYY HH:mm" data-target="#reservationdatetime" />
                           <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="card-footer">
               <div class="float-right">
                  <button type="button" onclick="back()" class="btn btn-danger text-sm">Cancel</button>
                  <button type="submit" class="btn btn-primary text-sm">Update</button>
               </div>
            </div>
            <?= form_close() ?>
         </div>
      </div>
   </section>
</div>

<script type="text/javascript">
   $(document).ready(function () {
      $('#reservationdatetime').datetimepicker({
         icons: { time: 'far fa-clock' },
         format: 'DD-MM-YYYY HH:mm',
         defaultDate: moment("<?= date('d-m-Y H:i', strtotime($questioner->deadline)) ?>", "DD-MM-YYYY HH:mm")
      });

      $('.formEditQuestioner').submit(function (e) {
         e.preventDefault();
         const form = $(this);
         const submitBtn = form.find('button[type=submit]');
         submitBtn.prop('disabled', true).text('Updating...');

         const deadlineVal = $('#deadline').val().trim();
         if (deadlineVal === "") {
            toastr.error('Deadline tidak boleh kosong');
            submitBtn.prop('disabled', false).text('Update');
            return;
         }

         $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
               if (response.error) {
                  let errorMsg = typeof response.error === 'string' ? response.error : 'Terjadi kesalahan input.';
                  toastr.error(errorMsg);
                  submitBtn.prop('disabled', false).text('Update');
               }
               if (response.success) {
                  Swal.fire({
                     icon: 'success',
                     title: 'Berhasil',
                     text: response.success,
                     showCancelButton: false,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  setTimeout(function () {
                     window.location.href = "<?= base_url('questioner/questioner') ?>";
                  }, 1500);
               }
            },
            error: function (xhr, status, error) {
               alert("Terjadi kesalahan: " + xhr.status + "\n" + xhr.responseText + "\n" + error);
               submitBtn.prop('disabled', false).text('Update');
            }
         });
      });
   });

   function back() {
      window.location.href = "<?= base_url('questioner/questioner') ?>";
   }
</script>
